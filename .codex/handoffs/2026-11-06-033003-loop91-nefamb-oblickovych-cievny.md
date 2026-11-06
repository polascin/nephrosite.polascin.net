# Handoff: loop91-nefamb-oblickovych-cievny

## Metadata

- Generated At: 2026-11-06T03:30:03+01:00
- Updated At: 2026-11-06T03:30:03+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 21d6901 (docs tip follows)

## Original Goal

Loop iterácia #91: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy/a11y/tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative /
dialyza-transplant EN gloss (#65) / purifikacia-GvHD (#66) /
dialyza dwell-time (#67) / nefamb synonym piles (#68) /
ľadvina+KTx piles (#69) / dialyza centre/membrane/cykler (#70) /
purifikácia očisťovanie/membrane (#71) / nefrologia CKD/AKI (#72) /
USG ultrasonografické (#73) / nefamb ESKD dual (#74) /
IgAN residual ESRD→ESKD (#75) / USG gel aplikácia→nanášanie (#76) /
lecture `suplementá`→`suplementy` (#77) /
nefamb/IgAN `s cieľom`→`aby …` (#78) /
IgAN genetiky/prospieť (#79) /
IgAN `smernice`→`usmernenia` (#80) /
USG `v reálnom čase`→`okamžite` (#81) /
dialýza `takzvanej online hemodiafiltrácia` (#82) /
ipvrm `v reálnom čase`→`priebežne` (#83) /
IgAN glomerular hypotenzi→hypertenzi (#84) /
IgAN `kaukazský`→`európsky pôvod` (#85) /
IgAN `paradigme`→`modeli liečby` (#86) /
IgAN ET-1 `regulácia`→`zvýšená tvorba` (#87) /
transplant `dobu dožitia`→`dlhšie prežívanie` (#88) /
transplant `preferovanou`→`uprednostňovanou` (#89) /
IgAN garbled NP (#90);
preferovaný ship: nefamb `renálnych (obličkových)` /
`cievny (vaskulárny)` → `obličkových` / `cievny`;
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.
Nie Lipton `jedinec`. Grok: ak nie je NephroSite kanál, len krátko
poznamenať.

## Current State

Iterácia #91 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: nefamb synonym piles —
`renálnych (obličkových)` → `obličkových`;
`cievny (vaskulárny)` → `cievny`.
Product SHA `21d6901` (docs tip nasleduje).
Grok/XAI MCP kanál pre NephroSite neexistuje; žiadna inventovaná Grok
analýza.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton /
  homepage-dative / privacy/cookie/Amazon / synonym piles #65–#90
  untouched.
- Preferred ship: nefamb dual glosses in patient copy.
- `files/nefamb.html`:
  `funkčných renálnych (obličkových) testov` →
  `funkčných obličkových testov`;
  `cievny (vaskulárny) prístup` → `cievny prístup`.
- Tooling: `scan-patient-copy.ps1` 2 rules
  (`renálnych \(obličkových\)`, `cievny \(vaskulárny\)`); README.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `21d6901`; post-commit SFTP uploaded
  `files/nefamb.html` (tools skipped by deployignore);
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42150629413` success (rsync skipped)
- Command: production Chrome UA `/nefamb` →
  `obličkových testov` ×1; residual `renálnych (obličkových)` 0;
  `cievny prístup` ×1; residual `cievny (vaskulárny)` 0;
  `/` `/ipvrm.htm` `/dialyza` `/nefamb` `/nefrologia` `/usgo`
  `/transplantacia` `/privacy` `/terms` `/purifikacia` → 200 + HSTS +
  CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #92: re-run `csp-report-summary.ps1` (+ blank-hints +
      patient-copy scans); drop `'unsafe-inline'` only with strong
      evidence (+ Clarity/GTM consent paths; watch total and
      Clarity/GTM-GA/Fastbase breakdown).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      privacy/terms/cookie / intro-Amazon / Lipton / homepage-dative /
      dialyza-transplant EN gloss / purifikacia-GvHD / dialyza dwell-time /
      nefamb synonym piles / ľadvina+KTx piles / dialyza
      centre/membrane/cykler piles / purifikácia očisťovanie/membrane /
      nefrologia CKD/AKI `resp.` piles / USG ultrasonografické piles /
      nefamb ESKD dual (#74) / IgAN residual ESRD→ESKD (#75) /
      USG gel aplikácia→nanášanie (#76) /
      lecture suplementá→suplementy (#77) /
      nefamb/IgAN `s cieľom`→`aby …` (#78) /
      IgAN genetiky/prospieť (#79) /
      IgAN `smernice`→`usmernenia` (#80) /
      USG `v reálnom čase`→`okamžite` (#81) /
      dialýza `takzvanej online HDF`→`online hemodiafiltrácia` (#82) /
      ipvrm `v reálnom čase`→`priebežne` (#83) /
      IgAN glomerular hypotenzi→hypertenzi (#84) /
      IgAN `kaukazský`→`európsky pôvod` (#85) /
      IgAN `paradigme`→`modeli liečby` (#86) /
      IgAN ET-1 `regulácia`→`zvýšená tvorba` (#87) /
      transplant `dobu dožitia`→`dlhšie prežívanie` (#88) /
      transplant `preferovanou`→`uprednostňovanou` (#89) /
      IgAN garbled NP (#90) /
      práve-shipnutý nefamb `obličkových`/`cievny` (#91);
      soft kandidáti: nefamb `brušnú (peritoneálnu) membránu` /
      `močovým systémom (uropoetickým aparátom)` /
      `vnútornom lekárstve (internej medicíne)`;
      iný verified patient-copy/a11y/tooling mimo churn listu.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship nefamb `renálnych (obličkových)` → `obličkových` and
  `cievny (vaskulárny)` → `cievny`.
- Reason: Patient-copy synonym dual gloss; prefer clear SK forms;
  distinct from #68 CKD dual-acronym piles.
- Decision: Sync only `files/nefamb.html` (no segments mirror).
- Reason: `nefamb.php` loads `files/nefamb.html` directly.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory, Lipton,
  privacy/terms/cookie, Amazon, homepage dative, piles #65–#90,
  Katetrizácia parenthetical gloss untouched.
- Reason: Avoid tip and just-shipped path churn; keep one coherent ship.
- Decision: No Grok collaboration text.
- Reason: No NephroSite Grok/XAI channel/tools available; do not invent.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/nefamb.html`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md` (Beh #100)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- 21d6901 Tighten nefamb synonym piles to clear patient Slovak.
- 028355e Document loop #90 IgAN specifickej populacii cleanup after smoke-only CSP telemetry.
- 640684a Fix IgAN garbled treatment NP to natural Slovak.
- 2e797b3 Document loop #89 transplant uprednostňovanou cleanup after smoke-only CSP telemetry.
- 928d9c6 Replace transplant preferovanou EN calque with uprednostňovanou.

## Modified Files

- After docs commit: SESSION.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #100)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-033003-loop91-nefamb-oblickovych-cievny.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`, `tools/scan-blank-hints.ps1`,
  `tools/scan-patient-copy.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-033003-loop91-nefamb-oblickovych-cievny.md.
Pokračuj loop #92 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/dialyza-transplant EN gloss/purifikacia-GvHD/dialyza dwell-time/nefamb synonym piles/ľadvina+KTx piles/dialyza centre-membrane-cykler piles/purifikácia očisťovanie-membrane piles/nefrologia CKD-AKI resp. piles/USG ultrasonografické piles/nefamb ESKD dual (#74)/IgAN residual ESRD→ESKD (#75)/USG gel aplikácia→nanášanie (#76)/lecture suplementá→suplementy (#77)/nefamb/IgAN s cieľom→aby (#78)/IgAN genetiky/prospieť (#79)/IgAN smernice→usmernenia (#80)/USG v reálnom čase→okamžite (#81)/dialýza takzvanej online HDF→online hemodiafiltrácia (#82)/ipvrm v reálnom čase→priebežne (#83)/IgAN glomerular hypotenzi→hypertenzi (#84)/IgAN kaukazský→európsky pôvod (#85)/IgAN paradigme→modeli liečby (#86)/IgAN ET-1 regulácia→zvýšená tvorba (#87)/transplant dobu dožitia→dlhšie prežívanie (#88)/transplant preferovanou→uprednostňovanou (#89)/IgAN garbled NP (#90)/práve-shipnutý nefamb obličkových/cievny (#91) churn. Soft kandidáti: nefamb brušnú (peritoneálnu) membránu / močovým systémom (uropoetickým aparátom) / vnútornom lekárstve (internej medicíne); iný verified patient-copy/a11y/tooling mimo churn listu. Spustiť aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
