#!/usr/bin/env bash
# ============================================================
#  Probe Journals — Local Dev Server Launcher
# ============================================================
#  Run from the project root:  ./start.sh
#
#  Requirements: PHP 8.2+, MySQL 8.0+
#    Install PHP:           brew install php
#    Install MySQL:         brew install mysql
#    Start MySQL:           brew services start mysql
#    First-time DB setup:   ./setup_db.sh
# ============================================================

set -e

# Check PHP
if ! command -v php &>/dev/null; then
    echo "❌  PHP not found. Install it with:"
    echo "    brew install php"
    exit 1
fi

PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;')
echo "✅  PHP $PHP_VERSION found"

# Check required extensions
MISSING=()
for ext in pdo pdo_mysql mbstring fileinfo; do
    if ! php -m | grep -qi "^$ext$"; then
        MISSING+=("$ext")
    fi
done
if [ ${#MISSING[@]} -gt 0 ]; then
    echo "⚠️  Missing PHP extensions: ${MISSING[*]}"
    echo "   Run: brew install php  (includes all required extensions)"
fi

# Ensure upload directories exist and are writable
mkdir -p public/assets/uploads/pdfs
mkdir -p public/assets/uploads/editors
mkdir -p public/assets/uploads/indexing
chmod -R 755 public/assets/uploads
echo "✅  Upload directories ready"

# Set env vars for local dev
export SITE_URL="http://localhost:8080"
export DB_HOST="localhost"
export DB_NAME="probe_journals"
export DB_USER="root"
export DB_PASS=""           # Change if your MySQL root has a password

PORT=${PORT:-8080}
echo ""
echo "🚀  Starting Probe Journals on http://localhost:$PORT"
echo "    Public site  → http://localhost:$PORT/"
echo "    Admin panel  → http://localhost:$PORT/admin/"
echo "    Admin login: username=admin  password=Admin@123"
echo ""
echo "    Press Ctrl+C to stop."
echo ""

php -S "localhost:$PORT" router.php
