#!/bin/sh
# Post-commit SFTP upload for NephroSite. Honors repo-root .deployignore
# (same exclude intent as tools/deploy.ps1 / GH Actions rsync). Does not
# delete remote files for ignored paths. Install:
#   cp tools/hooks/post-commit-deploy.sh .git/hooks/deploy.sh
SFTP_KEY="$HOME/.ssh/nephrosite_deploy"
SFTP_HOST="shell.r1.websupport.sk"
SFTP_USER="uid58858"
SFTP_PORT="26650"
REMOTE_PATH="/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nephrosite"

REPO_ROOT=$(git rev-parse --show-toplevel 2>/dev/null) || exit 0
cd "$REPO_ROOT" || exit 0

if [ ! -f "$SFTP_KEY" ]; then echo "[deploy] SSH kľúč nenájdený — preskakujem."; exit 0; fi

# Return 0 if path matches a .deployignore pattern (rsync-style basename/prefix/glob).
ignored_by_deployignore() {
    f=$1
    [ -f .deployignore ] || return 1
    while IFS= read -r pat || [ -n "$pat" ]; do
        pat=$(printf '%s' "$pat" | tr -d '\r')
        case "$pat" in
            ''|'#'*) continue ;;
        esac
        case "$pat" in
            *\**|*\?*)
                # shell glob against full path and basename
                base=${f##*/}
                # shellcheck disable=SC2254
                case "$f" in $pat) return 0 ;; esac
                # shellcheck disable=SC2254
                case "$base" in $pat) return 0 ;; esac
                ;;
            *)
                case "$f" in
                    "$pat"|"$pat"/*) return 0 ;;
                esac
                ;;
        esac
    done < .deployignore
    return 1
}

filter_paths() {
    while IFS= read -r f; do
        f=$(printf '%s' "$f" | tr -d '\r')
        [ -z "$f" ] && continue
        case "$f" in
            .claude/*|.vscode/*) continue ;;
        esac
        if ignored_by_deployignore "$f"; then
            echo "[deploy] skip (deployignore): $f" >&2
            continue
        fi
        printf '%s\n' "$f"
    done
}

UPLOAD=$(git diff-tree --no-commit-id -r --diff-filter=ACMR --name-only HEAD 2>/dev/null | filter_paths)
DELETE=$(git diff-tree --no-commit-id -r --diff-filter=D --name-only HEAD 2>/dev/null | filter_paths)
if [ -z "$UPLOAD" ] && [ -z "$DELETE" ]; then exit 0; fi

SCRIPT_FILE=$(mktemp /tmp/nephrosite_deploy_XXXXX.sftp)
if [ -n "$DELETE" ]; then
    echo "$DELETE" | while IFS= read -r f; do
        f=$(printf '%s' "$f" | tr -d '\r'); [ -z "$f" ] && continue
        printf -- '-rm "%s/%s"\n' "$REMOTE_PATH" "$f" >> "$SCRIPT_FILE"
    done
fi
if [ -n "$UPLOAD" ]; then
    echo "$UPLOAD" | while IFS= read -r f; do
        f=$(printf '%s' "$f" | tr -d '\r'); [ -z "$f" ] && continue
        dir=$(dirname "$f")
        if [ "$dir" != "." ]; then
            current=""; IFS='/' read -ra PARTS <<< "$dir"
            for part in "${PARTS[@]}"; do
                current="$current/$part"
                printf -- '-mkdir "%s%s"\n' "$REMOTE_PATH" "$current" >> "$SCRIPT_FILE"
            done
        fi
        printf 'put "%s" "%s/%s"\n' "$f" "$REMOTE_PATH" "$f" >> "$SCRIPT_FILE"
    done
fi
if [ ! -s "$SCRIPT_FILE" ]; then rm -f "$SCRIPT_FILE"; exit 0; fi

echo "[deploy] Uploading na $SFTP_HOST..."
sftp -i "$SFTP_KEY" -P "$SFTP_PORT" -o StrictHostKeyChecking=accept-new -o BatchMode=yes -b "$SCRIPT_FILE" "${SFTP_USER}@${SFTP_HOST}" 2>&1
RC=$?; rm -f "$SCRIPT_FILE"
[ $RC -eq 0 ] && echo "[deploy] Hotovo! ($(date '+%d.%m.%Y %H:%M'), $(git rev-parse --abbrev-ref HEAD)@$(git rev-parse --short HEAD))" || echo "[deploy] Chyba ($RC)"
