#!/usr/bin/env bash
set -euo pipefail

REPO_URL="${PS_SHARED_UI_GIT_URL:-https://github.com/Power-Source/ps-shared-ui.git}"
REPO_REF="${PS_SHARED_UI_REF:-main}"
LOCAL_SOURCE="${PS_SHARED_UI_LOCAL_PATH:-}"

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PLUGIN_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
TMP_DIR="$(mktemp -d)"
SOURCE_DIR=""

cleanup() {
  rm -rf "$TMP_DIR"
}
trap cleanup EXIT

copy_if_exists() {
  local src="$1"
  local dst="$2"
  if [[ -f "$src" ]]; then
    mkdir -p "$(dirname "$dst")"
    cp -f "$src" "$dst"
  fi
}

echo "Syncing Shared UI from $REPO_URL@$REPO_REF"
if git clone --depth 1 --branch "$REPO_REF" "$REPO_URL" "$TMP_DIR/repo" >/dev/null 2>&1; then
  SOURCE_DIR="$TMP_DIR/repo"
else
  if [[ -z "$LOCAL_SOURCE" ]]; then
    LOCAL_SOURCE="$PLUGIN_DIR/../ps-shared-ui"
  fi
  if [[ -d "$LOCAL_SOURCE" ]]; then
    echo "GitHub source not reachable, using local fallback: $LOCAL_SOURCE"
    SOURCE_DIR="$LOCAL_SOURCE"
  else
    echo "Failed to fetch Shared UI from GitHub and local fallback not found."
    exit 1
  fi
fi

copy_if_exists "$SOURCE_DIR/dist/shared-ui.js" "$PLUGIN_DIR/assets/js/shared-ui.js"
copy_if_exists "$SOURCE_DIR/dist/shared-ui.min.css" "$PLUGIN_DIR/assets/css/shared-ui.min.css"
copy_if_exists "$SOURCE_DIR/js/admin-components.js" "$PLUGIN_DIR/assets/js/admin-components.js"
copy_if_exists "$SOURCE_DIR/js/clipboard.js" "$PLUGIN_DIR/external/clipboard/clipboard.js"
copy_if_exists "$SOURCE_DIR/js/a11y-dialog.js" "$PLUGIN_DIR/external/a11y-dialog/a11y-dialog.js"
copy_if_exists "$SOURCE_DIR/js/select2.full.js" "$PLUGIN_DIR/external/select2/select2.full.js"
copy_if_exists "$SOURCE_DIR/js/sortable.min.js" "$PLUGIN_DIR/external/sortablejs/Sortable.min.js"
copy_if_exists "$SOURCE_DIR/js/moment.min.js" "$PLUGIN_DIR/assets/js/vendor/moment.min.js"
copy_if_exists "$SOURCE_DIR/js/daterangepicker.min.js" "$PLUGIN_DIR/assets/js/vendor/daterangepicker.min.js"
copy_if_exists "$SOURCE_DIR/css/daterangepicker.min.css" "$PLUGIN_DIR/assets/css/vendor/daterangepicker.min.css"
copy_if_exists "$SOURCE_DIR/js/wp-color-picker-alpha.min.js" "$PLUGIN_DIR/external/wp-color-picker-alpha/wp-color-picker-alpha.min.js"
copy_if_exists "$SOURCE_DIR/js/wp-color-picker-alpha-modern.js" "$PLUGIN_DIR/external/wp-color-picker-alpha/wp-color-picker-alpha-modern.js"
copy_if_exists "$SOURCE_DIR/js/choices.min.js" "$PLUGIN_DIR/external/choices/choices.min.js"
copy_if_exists "$SOURCE_DIR/css/choices.min.css" "$PLUGIN_DIR/assets/css/vendor/choices.min.css"

echo "Shared UI sync complete for psource-branding"
