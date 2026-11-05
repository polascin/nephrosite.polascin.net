# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #14)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `ca9387f` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: zosúladenie h2/h1 s `$topic['title']` pre `/purifikacia`,
  `/transplantacia`, `/lipton-tx`; oprava markup typov `R<em>iziká` a
  `K<strong>omplikácie`; title-aware homepage teaser; odstránenie mŕtveho
  odkazu na `clustrmaps.com` (DNS → 127.0.0.1); first-party SVG + figcaption;
  odstránený duplicitný Fedora badge.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0): `/` `/privacy` `/terms`
  `/nefrologia` `/purifikacia` `/transplantacia` `/lipton-tx` `/nefamb`
  → 200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Commit `ca9387f`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload; smoke
  direct 200
- Produkcia: h1 match titles; homepage `visitor-map` + figcaption; bez
  `clustrmaps.com/site`; bez `R<em>izik` / `K<strong>omplik`
- GHA Deploy `42097461973` success (rsync skip)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.
- Lokálny `tools/deploy.ps1 -Apply` (+ post-commit SFTP) je autoritatívny
  sync, kým chýbajú `DEPLOY_*` secrets.
- ClustrMaps A záznam aj cez 8.8.8.8 / 1.1.1.1 → `127.0.0.1` (nie len lokálny
  sinkhole); outbound link zostáva vypnutý, kým vendor neodžije.

## Ďalší fokus (loop #15)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only (napr. ďalšie
   footer linky s 403, segments vs files title drift na transplantáciách).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-205024-loop14-topic-titles-clustrmaps.md`
- Audit: `.audit.md` Beh #25

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
