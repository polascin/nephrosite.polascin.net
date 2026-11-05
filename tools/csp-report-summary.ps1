<#
.SYNOPSIS
    Summarize private CSP Report-Only / enforced violation telemetry on WebSupport.

.DESCRIPTION
    Pulls private/csp-reports/reports.jsonl over the SSH alias websupport (never
    exposes the log publicly). Aggregates blocked-uri, violated/effective
    directive, disposition, and document-uri. Use before deciding whether to
    drop 'unsafe-inline' from the enforced script-src.

.PARAMETER SshHost
    SSH alias (default: websupport).

.PARAMETER RemotePath
    Absolute path to the NephroSite web root on the server.

.PARAMETER MaxLines
    Optional cap on how many trailing JSONL lines to load (0 = all).

.EXAMPLE
    powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
#>
[CmdletBinding()]
param(
    [string] $SshHost = 'websupport',
    [string] $RemotePath = '/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nephrosite',
    [int]    $MaxLines = 0
)

Set-StrictMode -Version 2.0
$ErrorActionPreference = 'Stop'

$remoteLog = "$RemotePath/private/csp-reports/reports.jsonl"
$remoteCmd = @"
if [ ! -f '$remoteLog' ]; then echo '__MISSING__'; exit 0; fi
wc -l < '$remoteLog'
echo '__BODY__'
if [ '$MaxLines' -gt 0 ]; then
  tail -n $MaxLines '$remoteLog'
else
  cat '$remoteLog'
fi
"@

$raw = & ssh -o BatchMode=yes $SshHost $remoteCmd 2>&1
if ($LASTEXITCODE -ne 0) {
    throw ("ssh failed ({0}): {1}" -f $LASTEXITCODE, ($raw -join "`n"))
}

$text = ($raw | ForEach-Object { "$_" }) -join "`n"
if ($text -match '__MISSING__') {
    Write-Host 'No reports.jsonl on server yet (empty telemetry).'
    exit 0
}

$parts = $text -split '__BODY__', 2
$countLine = ($parts[0] -split "`n" | Where-Object { $_.Trim() -ne '' } | Select-Object -Last 1).Trim()
$body = if ($parts.Count -gt 1) { $parts[1].Trim() } else { '' }

$lines = @()
if ($body.Length -gt 0) {
    $lines = $body -split "`n" | Where-Object { $_.Trim().Length -gt 0 }
}

Write-Host ("CSP report lines on server: {0}" -f $countLine)
Write-Host ("Lines loaded for summary:   {0}" -f $lines.Count)
if ($lines.Count -eq 0) {
    Write-Host 'Telemetry empty: do not drop enforced unsafe-inline yet.'
    exit 0
}

$byBlocked = @{}
$byDirective = @{}
$byDisposition = @{}
$byDocument = @{}
$smokeMarkers = 0
$realCandidates = 0
$consentPathHits = 0
$clarityHits = 0
$gtmGaHits = 0
$fastbaseHits = 0

function Get-ReportField {
    param($Report, [string]$Name)
    if ($null -eq $Report) { return '' }
    $prop = $Report.PSObject.Properties[$Name]
    if ($null -eq $prop) { return '' }
    return [string]$prop.Value
}

foreach ($line in $lines) {
    try {
        $obj = $line | ConvertFrom-Json
    } catch {
        continue
    }
    $r = $null
    if ($null -ne $obj -and $null -ne $obj.PSObject.Properties['report']) {
        $r = $obj.report
    }
    if ($null -eq $r) { continue }

    $blocked = Get-ReportField -Report $r -Name 'blocked-uri'
    if ([string]::IsNullOrWhiteSpace($blocked)) { $blocked = '(empty)' }
    $directive = Get-ReportField -Report $r -Name 'violated-directive'
    if ([string]::IsNullOrWhiteSpace($directive)) {
        $directive = Get-ReportField -Report $r -Name 'effective-directive'
    }
    if ([string]::IsNullOrWhiteSpace($directive)) { $directive = '(empty)' }
    $disposition = Get-ReportField -Report $r -Name 'disposition'
    if ([string]::IsNullOrWhiteSpace($disposition)) { $disposition = '(empty)' }
    $document = Get-ReportField -Report $r -Name 'document-uri'
    if ([string]::IsNullOrWhiteSpace($document)) { $document = '(empty)' }
    $sample = Get-ReportField -Report $r -Name 'script-sample'
    $sourceFile = Get-ReportField -Report $r -Name 'source-file'

    if (-not $byBlocked.ContainsKey($blocked)) { $byBlocked[$blocked] = 0 }
    $byBlocked[$blocked]++
    if (-not $byDirective.ContainsKey($directive)) { $byDirective[$directive] = 0 }
    $byDirective[$directive]++
    if (-not $byDisposition.ContainsKey($disposition)) { $byDisposition[$disposition] = 0 }
    $byDisposition[$disposition]++
    if (-not $byDocument.ContainsKey($document)) { $byDocument[$document] = 0 }
    $byDocument[$document]++

    $looksLikeSmoke = ($blocked -match 'evil\.example') -or (
        $blocked -eq 'inline' -and
        [string]::IsNullOrWhiteSpace($sample) -and
        [string]::IsNullOrWhiteSpace($sourceFile)
    )
    if ($looksLikeSmoke) {
        $smokeMarkers++
    } else {
        $realCandidates++
    }

    # Vendor hosts loaded only after analytics/marketing consent.
    $isClarity = $blocked -match '(?i)clarity\.ms'
    $isGtmGa = $blocked -match '(?i)googletagmanager\.com|google-analytics\.com|googletagservices\.com'
    $isFastbase = $blocked -match '(?i)fastbase\.com'
    if ($isClarity -or $isGtmGa -or $isFastbase) {
        $consentPathHits++
        if ($isClarity) { $clarityHits++ }
        if ($isGtmGa) { $gtmGaHits++ }
        if ($isFastbase) { $fastbaseHits++ }
    }
}

function Write-CountTable {
    param([hashtable]$Map, [string]$Title, [int]$Top = 15)
    Write-Host ""
    Write-Host $Title
    $Map.GetEnumerator() |
        Sort-Object -Property Value -Descending |
        Select-Object -First $Top |
        ForEach-Object { Write-Host ("  {0,5}  {1}" -f $_.Value, $_.Key) }
}

Write-CountTable -Map $byBlocked -Title 'blocked-uri'
Write-CountTable -Map $byDirective -Title 'violated/effective-directive'
Write-CountTable -Map $byDisposition -Title 'disposition'
Write-CountTable -Map $byDocument -Title 'document-uri'

Write-Host ""
Write-Host ("Likely smoke/test markers: {0}" -f $smokeMarkers)
Write-Host ("Other / real candidates:   {0}" -f $realCandidates)
Write-Host ("Clarity/GTM/vendor hits:   {0}" -f $consentPathHits)
Write-Host ("  Clarity:                 {0}" -f $clarityHits)
Write-Host ("  GTM/GA:                  {0}" -f $gtmGaHits)
Write-Host ("  Fastbase:                {0}" -f $fastbaseHits)
if ($realCandidates -eq 0) {
    Write-Host "Verdict: telemetry too fresh or smoke-only. Keep enforced 'unsafe-inline'."
} elseif ($consentPathHits -eq 0) {
    Write-Host "Verdict: real candidates present, but no Clarity/GTM/vendor blocks yet. Keep 'unsafe-inline' until consent-path evidence is reviewed."
} else {
    Write-Host "Verdict: review real candidates (Clarity/GTM consent paths) before tightening enforced script-src."
}
