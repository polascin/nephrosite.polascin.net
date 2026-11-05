<#
.SYNOPSIS
    Scan NephroSite markup for target=_blank links missing a new-window hint.

.DESCRIPTION
    Strips HTML comments first (excluded vendor logos and commented intro Bory
    must not inflate misses), then matches full <a>...</a> anchors so a late
    <span class="sr-only"> inside a large PDF card is not a false positive.
    Also flags "na stiahnutie" / "stiahnuť" claims without a download attribute,
    and <img> tags missing alt (skips PHP regex/source lines that only mention
    the <img> pattern, e.g. topic-teaser.php).

.PARAMETER Roots
    Relative roots to scan (default: files, segments, blocks, promo, plus
    top-level ipvrm.htm when present).

.PARAMETER FailOnMiss
    Exit 1 when any miss is found (default: true).

.EXAMPLE
    powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
#>
[CmdletBinding()]
param(
    [string[]] $Roots = @('files', 'segments', 'blocks', 'promo'),
    [bool]     $FailOnMiss = $true
)

Set-StrictMode -Version 2.0
$ErrorActionPreference = 'Stop'

$repoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $repoRoot

function Get-ScanFiles {
    param([string[]] $ScanRoots)
    $list = New-Object System.Collections.Generic.List[System.IO.FileInfo]
    foreach ($root in $ScanRoots) {
        $path = Join-Path $repoRoot $root
        if (-not (Test-Path -LiteralPath $path)) { continue }
        Get-ChildItem -LiteralPath $path -Recurse -File -Include *.html, *.htm, *.php |
            Where-Object { $_.FullName -notmatch '[\\/]\.kilo[\\/]' } |
            ForEach-Object { [void]$list.Add($_) }
    }
    $ipvrm = Join-Path $repoRoot 'ipvrm.htm'
    if (Test-Path -LiteralPath $ipvrm) {
        [void]$list.Add((Get-Item -LiteralPath $ipvrm))
    }
    return $list
}

function Get-RelativePath {
    param([string] $FullPath)
    return $FullPath.Substring($repoRoot.Length).TrimStart('\', '/')
}

function Test-IsImgPatternSourceLine {
    param([string] $TagContext)
    # topic-teaser.php and similar keep an <img\b regex in PHP source; not live markup.
    return ($TagContext -match 'preg_match' -or $TagContext -match '#<img\\b' -or $TagContext -match "'<img\\b" -or $TagContext -match '"<img\\b')
}

$blankMisses = New-Object System.Collections.Generic.List[string]
$downloadMisses = New-Object System.Collections.Generic.List[string]
$imgMisses = New-Object System.Collections.Generic.List[string]

foreach ($file in (Get-ScanFiles -ScanRoots $Roots)) {
    $raw = [IO.File]::ReadAllText($file.FullName)
    $stripped = [regex]::Replace($raw, '(?s)<!--.*?-->', '')
    $rel = Get-RelativePath -FullPath $file.FullName

    foreach ($m in [regex]::Matches($stripped, '(?is)<a\b[^>]*target\s*=\s*["'']_blank["''][^>]*>.*?</a>')) {
        $anchor = $m.Value
        $hasHint = ($anchor -match '(?i)class\s*=\s*["''][^"'']*\bsr-only\b') -or
            ($anchor -match '(?i)otvorí sa v novom okne') -or
            ($anchor -match '(?i)\baria-label\s*=')
        if (-not $hasHint) {
            $open = ([regex]::Match($anchor, '(?is)<a\b[^>]*>')).Value
            $snippet = $open.Substring(0, [Math]::Min(140, $open.Length))
            [void]$blankMisses.Add(("{0} :: {1}" -f $rel, $snippet))
        }
    }

    foreach ($m in [regex]::Matches($stripped, '(?is)<a\b[^>]*>.*?</a>')) {
        $anchor = $m.Value
        if ($anchor -match '(?i)na stiahnutie|stiahnuť' -and $anchor -notmatch '(?i)\bdownload\b') {
            $open = ([regex]::Match($anchor, '(?is)<a\b[^>]*>')).Value
            $snippet = $open.Substring(0, [Math]::Min(140, $open.Length))
            [void]$downloadMisses.Add(("{0} :: {1}" -f $rel, $snippet))
        }
    }

    foreach ($m in [regex]::Matches($stripped, '(?is)<img\b[^>]*>')) {
        $tag = $m.Value
        if ($tag -match '(?i)\balt\s*=') { continue }
        $start = [Math]::Max(0, $m.Index - 80)
        $ctx = $stripped.Substring($start, [Math]::Min(200, $stripped.Length - $start))
        if (Test-IsImgPatternSourceLine -TagContext $ctx) { continue }
        $snippet = $tag.Substring(0, [Math]::Min(140, $tag.Length))
        [void]$imgMisses.Add(("{0} :: {1}" -f $rel, $snippet))
    }
}

Write-Host ("Blank _blank misses (no new-window hint): {0}" -f $blankMisses.Count)
$blankMisses | ForEach-Object { Write-Host ("  {0}" -f $_) }
Write-Host ("Download-claim misses (no download attr): {0}" -f $downloadMisses.Count)
$downloadMisses | ForEach-Object { Write-Host ("  {0}" -f $_) }
Write-Host ("Img missing alt (live markup):            {0}" -f $imgMisses.Count)
$imgMisses | ForEach-Object { Write-Host ("  {0}" -f $_) }

$total = $blankMisses.Count + $downloadMisses.Count + $imgMisses.Count
if ($total -eq 0) {
    Write-Host 'Verdict: a11y blank/download/alt scan clean.'
    exit 0
}

Write-Host ("Verdict: {0} miss(es) to review." -f $total)
if ($FailOnMiss) {
    exit 1
}
exit 0
