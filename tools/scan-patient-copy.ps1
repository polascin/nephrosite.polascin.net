<#
.SYNOPSIS
    Scan NephroSite patient/UI markup for known Slovak wording regressions.

.DESCRIPTION
    Encodes high-confidence SESSION.md patient-copy lessons (bohemisms,
    calques, defective constructions already fixed in tip-path topics).
    Skips privacy/terms/cookie-banner legal pages and .kilo worktrees.
    Allowlists: Lipton literary jedinec/jedincov; ABPM "Ambulantné
    monitorovanie"; Lipton spiritual "vizualizácie".

.PARAMETER Roots
    Relative roots to scan (default: files, segments, blocks).

.PARAMETER FailOnMiss
    Exit 1 when any unallowlisted hit is found (default: true).

.EXAMPLE
    powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
#>
[CmdletBinding()]
param(
    [string[]] $Roots = @('files', 'segments', 'blocks'),
    [bool]     $FailOnMiss = $true
)

Set-StrictMode -Version 2.0
$ErrorActionPreference = 'Stop'

$repoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $repoRoot

# Pattern, short label, optional per-hit allow predicate name
$rules = @(
    @{ Pattern = 'Zahrňuje'; Label = 'Zahrňuje (→ Zahŕňa)' }
    @{ Pattern = 'detekovať'; Label = 'detekovať (→ odhaliť)' }
    @{ Pattern = '\bv svojom\b'; Label = 'v svojom (→ vo svojom)' }
    @{ Pattern = 'zo rôznych'; Label = 'zo rôznych (→ z rôznych)' }
    @{ Pattern = 'Za účelom'; Label = 'Za účelom (→ Na + N)' }
    @{ Pattern = 'najoptimálnejš'; Label = 'najoptimálnejšie (→ najlepšie)' }
    @{ Pattern = 'sestričk'; Label = 'sestrička (→ sestra)' }
    @{ Pattern = 'nahradzuj'; Label = 'nahradzuj* (→ nahrádza/náhradná)' }
    @{ Pattern = '\d-\d krát\b'; Label = 'N-M krát (→ N-M-krát)' }
    @{ Pattern = 'z dôvodu'; Label = 'z dôvodu (→ pre + A)' }
    @{ Pattern = 'vylepši'; Label = 'vylepši* (→ zlepši*)' }
    @{ Pattern = '\bjedinci\b'; Label = 'jedinci (→ ľudia)' }
    @{ Pattern = 'jednotlivc'; Label = 'jednotlivec (→ človek)' }
    @{ Pattern = '\bmanažment\b'; Label = 'manažment (→ zvládanie)' }
    @{ Pattern = 'Propagáci'; Label = 'Propagácia (→ Osveta)' }
    @{ Pattern = 'platformu na'; Label = 'platformu na (→ priestor na)' }
    @{ Pattern = 'asymptomatick'; Label = 'asymptomatick* (→ bez príznakov)' }
    @{ Pattern = '\bTaktiež\b'; Label = 'Taktiež (→ Tiež/Musia tiež)' }
    @{ Pattern = 'glomerulárnej nefritídy'; Label = 'glomerulárnej nefritídy (→ glomerulonefritídy)' }
    @{ Pattern = 'dysbalanc'; Label = 'dysbalanc* (→ nerovnováh*)' }
    @{ Pattern = 'politických zmien'; Label = 'politických zmien (→ zdravotnej politike)' }
    @{ Pattern = 'environmentáln'; Label = 'environmentáln* (→ faktorov prostredia)' }
    @{ Pattern = 'poskytovateľ zdravotnej'; Label = 'poskytovateľ zdravotnej (→ lekár)' }
    @{ Pattern = 'adekvátneho odberu'; Label = 'adekvátneho odberu (→ správneho odberu)' }
    @{ Pattern = 'v prevažnej väčšine'; Label = 'v prevažnej väčšine (→ u prevažnej väčšiny)' }
    @{ Pattern = 'fotosenzitívn'; Label = 'fotosenzitívn* (→ fotosenzibilizujúcej)' }
    @{ Pattern = 'prevedie cez'; Label = 'prevedie cez (→ vedie cez)' }
    @{ Pattern = 'Medzi niektoré z'; Label = 'Medzi niektoré z (→ Medzi bežné)' }
    @{ Pattern = 'Ako sme už predtým'; Label = 'Ako sme už predtým (filler)' }
    @{ Pattern = 'riadenie chronických'; Label = 'riadenie chronických (→ zvládanie)' }
    @{ Pattern = 'zodpovedá na'; Label = 'zodpovedá na (→ odpovedá na)' }
    @{ Pattern = 'vizualizáciu'; Label = 'vizualizáciu (→ zobrazenie)' }
    @{ Pattern = 'V rámci kurzu'; Label = 'V rámci kurzu (→ V kurze)' }
    @{ Pattern = 'V rámci zasadnutia'; Label = 'V rámci zasadnutia (→ Na zasadnutí)' }
    @{ Pattern = 'V rámci inovatívneho'; Label = 'V rámci inovatívneho (→ V inovatívnom)' }
    @{ Pattern = 'Amazon-e'; Label = 'Amazon-e (→ Amazone)' }
    @{ Pattern = 'Lipton-a'; Label = 'Lipton-a (→ Liptona)' }
    @{ Pattern = 'pätu obsahových'; Label = 'pätu obsahových (→ pätičku stránky)' }
    @{ Pattern = 'stránku súkromia'; Label = 'stránku súkromia (→ zásady ochrany súkromia)' }
    @{ Pattern = 'mŕtveho darcu'; Label = 'mŕtveho darcu (→ zosnulého darcu)' }
    @{ Pattern = 'prenáša do pacienta'; Label = 'prenáša do pacienta (→ prenáša na)' }
    @{ Pattern = 'darcu \(donor'; Label = 'darcu (donor*) (→ darcu)' }
    @{ Pattern = 'zo strany lekárov'; Label = 'zo strany lekárov (úradnícky kalk)' }
    @{ Pattern = '\bcycler\b'; Label = 'cycler (→ cykler)' }
    @{ Pattern = 'zdieľajú s'; Label = 'zdieľajú s (→ odovzdajú/pošlú)' }
    @{ Pattern = 'v dôsledku rôznych príčin'; Label = 'v dôsledku rôznych príčin (→ pre rôzne príčiny)' }
    @{ Pattern = '\bakceptor\b'; Label = 'akceptor (→ príjemca)' }
    @{ Pattern = 'zobrať do úvahy'; Label = 'zobrať do úvahy (→ vziať do úvahy)' }
    @{ Pattern = '\btak isto\b'; Label = 'tak isto (→ takisto)' }
    @{ Pattern = '\bnato na\b'; Label = 'nato na (→ na to na)' }
    @{ Pattern = 'všeobecne medicíne'; Label = 'všeobecne medicíne (→ všeobecnej medicíne)' }
    @{ Pattern = 'pochádzajúcimi s\b'; Label = 'pochádzajúcimi s (→ z)' }
    @{ Pattern = 'prispôsobenie životného'; Label = 'prispôsobenie životného (→ úpravu)' }
    @{ Pattern = 'prispôsobeniu liekov'; Label = 'prispôsobeniu liekov (→ úprave)' }
    @{ Pattern = 'zabezpečenie hygieny potravín'; Label = 'zabezpečenie hygieny potravín (→ hygiena pri)' }
    @{ Pattern = 'v rámci glomerul'; Label = 'v rámci glomerul* (→ v glomeruloch)' }
    @{ Pattern = 'pre ľudia\b'; Label = 'pre ľudia (→ pre ľudí)' }
    @{ Pattern = 'umožnilo prenos'; Label = 'umožnilo prenos (→ umožnil)' }
    @{ Pattern = '\(morbidity\)'; Label = '(morbidity) EN gloss (→ chorobnosť alone)' }
    @{ Pattern = '\(mortality\)'; Label = '(mortality) EN gloss (→ úmrtnosť alone)' }
    @{ Pattern = 'orgánu \(rejekcia\)'; Label = 'orgánu (rejekcia) (→ odmietnutie orgánu)' }
    @{ Pattern = 'graft-versus-host disease'; Label = 'graft-versus-host disease EN gloss (→ GvHD after SK term)' }
    @{ Pattern = 'dwell time'; Label = 'dwell time EN gloss (→ čas pôsobenia)' }
    @{ Pattern = 'Hypertenzia \(vysoký krvný tlak\) \(HT\)'; Label = 'Hypertenzia … (HT) synonym pile (→ drop HT)' }
    @{ Pattern = 'Diabetická nefropatia \(Diabetická obličková choroba\) \(DKD\)'; Label = 'Diabetická nefropatia … (DKD) pile (→ drop DKD)' }
    @{ Pattern = 'glomerulárnej \(glomerulovej\)'; Label = 'glomerulárnej (glomerulovej) (→ glomerulovej)' }
    @{ Pattern = 'lupus erythematodes, erythematosus'; Label = 'lupus erythematodes, erythematosus (→ erythematosus)' }
    @{ Pattern = 'obličiek \(ľadvín\)'; Label = 'obličiek (ľadvín) synonym pile (→ obličiek)' }
    @{ Pattern = 'obličky \(ľadviny\)'; Label = 'obličky (ľadviny) synonym pile (→ obličky)' }
    @{ Pattern = 'transplantácie obličky \(ľadviny\)'; Label = 'transplantácie obličky (ľadviny) (→ bez ľadviny)' }
    @{ Pattern = 'KTx, RTx, NTx'; Label = 'KTx, RTx, NTx acronym pile (→ drop)' }
    @{ Pattern = 'stredisku, stacionári'; Label = 'centre (stredisku, stacionári) synonym pile (→ centre alone)' }
    @{ Pattern = 'peritoneálna membrána - peritoneum'; Label = 'peritoneum membrane pile (→ peritoneálna membrána (pobrušnica))' }
    @{ Pattern = 'brušná membrána, pobrušnica'; Label = 'brušná membrána, pobrušnica pile (→ pobrušnica)' }
    @{ Pattern = 'brušnú membránu, pobrušnicu'; Label = 'brušnú membránu, pobrušnicu pile (→ pobrušnicu)' }
    @{ Pattern = 'pobrušnicu, peritoneum'; Label = 'pobrušnicu, peritoneum pile (→ pobrušnicu)' }
    @{ Pattern = '"cyklovač"'; Label = 'cykler "cyklovač" synonym (→ cykler alone)' }
    @{ Pattern = 'očisťovanie, čistenie'; Label = 'očisťovanie, čistenie synonym pile (→ Purifikácia alone + teda gloss)' }
    @{ Pattern = 'Chronické zlyhanie obličiek, resp\. chronická'; Label = 'CKD resp. synonym pile (→ Chronická obličková choroba)' }
    @{ Pattern = 'Akútne zlyhanie obličiek, resp\. akútne'; Label = 'AKI resp. synonym pile (→ Akútne obličkové poškodenie)' }
)

function Get-ScanFiles {
    param([string[]] $ScanRoots)
    $list = New-Object System.Collections.Generic.List[System.IO.FileInfo]
    foreach ($root in $ScanRoots) {
        $path = Join-Path $repoRoot $root
        if (-not (Test-Path -LiteralPath $path)) { continue }
        Get-ChildItem -LiteralPath $path -Recurse -File -Include *.html, *.htm, *.php |
            Where-Object {
                $_.FullName -notmatch '[\\/]\.kilo[\\/]' -and
                $_.Name -notmatch '^(privacy|terms)\.html$' -and
                $_.Name -notmatch 'cookie-banner'
            } |
            ForEach-Object { [void]$list.Add($_) }
    }
    return $list
}

function Get-RelativePath {
    param([string] $FullPath)
    return $FullPath.Substring($repoRoot.Length).TrimStart('\', '/')
}

function Test-IsAllowlisted {
    param(
        [string] $RelPath,
        [string] $Line,
        [string] $Pattern
    )
    # Literary Lipton: keep jedinec/jedincov; spiritual vizualizácie is not patient UI "zobrazenie".
    if ($RelPath -match '(?i)lipton') {
        if ($Pattern -match 'jedin|vizualiz') { return $true }
    }
    # Official ABPM name in nefamb.
    if ($Pattern -match 'monitorov' -and $Line -match 'Ambulantné monitorovanie krvného tlaku') {
        return $true
    }
    return $false
}

$hits = New-Object System.Collections.Generic.List[string]

foreach ($file in (Get-ScanFiles -ScanRoots $Roots)) {
    $rel = Get-RelativePath -FullPath $file.FullName
    $lines = [IO.File]::ReadAllLines($file.FullName)
    for ($i = 0; $i -lt $lines.Length; $i++) {
        $line = $lines[$i]
        # Skip HTML comments (excluded vendor logos / commented intro Bory).
        if ($line -match '^\s*<!--' -or $line -match '-->\s*$') { continue }
        foreach ($rule in $rules) {
            if ($line -notmatch $rule.Pattern) { continue }
            if (Test-IsAllowlisted -RelPath $rel -Line $line -Pattern $rule.Pattern) { continue }
            $snippet = $line.Trim()
            if ($snippet.Length -gt 120) {
                $snippet = $snippet.Substring(0, 120) + '…'
            }
            [void]$hits.Add(("{0}:{1} [{2}] :: {3}" -f $rel, ($i + 1), $rule.Label, $snippet))
        }
    }
}

Write-Host ("Patient-copy regression hits: {0}" -f $hits.Count)
$hits | ForEach-Object { Write-Host ("  {0}" -f $_) }

if ($hits.Count -eq 0) {
    Write-Host 'Verdict: patient-copy scan clean (high-confidence SESSION patterns).'
    exit 0
}

Write-Host ("Verdict: {0} hit(s) to review." -f $hits.Count)
if ($FailOnMiss) {
    exit 1
}
exit 0
