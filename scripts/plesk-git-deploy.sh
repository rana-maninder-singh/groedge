#!/bin/bash
# Plesk Git "Additional deployment actions" script.
# Copies site files from public_html into ~/httpdocs.
#
# In Plesk → Websites & Domains → Git → your repo → Repository settings:
#   Additional deploy actions:
#     /bin/bash scripts/plesk-git-deploy.sh

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SRC="${REPO_ROOT}/public_html"
DEST="${HOME}/httpdocs"

if [[ ! -d "$SRC" ]]; then
  echo "ERROR: public_html not found at $SRC" >&2
  exit 1
fi

if [[ ! -d "$DEST" ]]; then
  echo "ERROR: httpdocs not found at $DEST" >&2
  exit 1
fi

PRESERVE_SUBMISSIONS="${DEST}/data/submissions.json"
PRESERVE_CONFIG="${DEST}/data/site-config.json"
BACKUP_SUB=""
BACKUP_CFG=""
if [[ -f "$PRESERVE_SUBMISSIONS" ]]; then
  BACKUP_SUB="$(mktemp)"
  cp -f "$PRESERVE_SUBMISSIONS" "$BACKUP_SUB"
fi
if [[ -f "$PRESERVE_CONFIG" ]]; then
  BACKUP_CFG="$(mktemp)"
  cp -f "$PRESERVE_CONFIG" "$BACKUP_CFG"
fi

if command -v rsync >/dev/null 2>&1; then
  rsync -a \
    --exclude '.well-known' \
    --exclude 'cgi-bin' \
    "${SRC}/" "${DEST}/"
else
  # Portable fallback when rsync is unavailable
  cp -fR "${SRC}/." "${DEST}/"
fi

mkdir -p "${DEST}/data"
if [[ -n "$BACKUP_SUB" && -f "$BACKUP_SUB" ]]; then
  mv -f "$BACKUP_SUB" "${DEST}/data/submissions.json"
fi
if [[ -n "$BACKUP_CFG" && -f "$BACKUP_CFG" ]]; then
  mv -f "$BACKUP_CFG" "${DEST}/data/site-config.json"
fi

chmod 755 "${DEST}/data" || true
chmod 644 "${DEST}/data/"*.json 2>/dev/null || true

echo "Deployed ${SRC} → ${DEST}"
