#!/usr/bin/env bash
# ============================================================
#  Probe Journals — First-time Database Setup
# ============================================================
#  Run once after installing MySQL:
#    brew install mysql
#    brew services start mysql
#    ./setup_db.sh
# ============================================================

set -e

DB_NAME="probe_journals"
DB_USER="root"
DB_PASS=""   # Leave blank if your local MySQL root has no password

echo "🗄️  Setting up database: $DB_NAME"

if [ -z "$DB_PASS" ]; then
    MYSQL_CMD="mysql -u $DB_USER"
else
    MYSQL_CMD="mysql -u $DB_USER -p$DB_PASS"
fi

# Test connection
if ! $MYSQL_CMD -e "SELECT 1" &>/dev/null; then
    echo "❌  Cannot connect to MySQL."
    echo "    Make sure MySQL is running: brew services start mysql"
    echo "    Or if your root has a password, edit DB_PASS in this script."
    exit 1
fi

echo "✅  Connected to MySQL"

# Import schema
$MYSQL_CMD < database/schema.sql

echo "✅  Schema imported: $DB_NAME"
echo "✅  Seed data loaded (9 journals + admin user)"
echo ""
echo "🎉  Database ready!"
echo "    Visit: http://localhost:8080/admin/"
echo "    Login: admin / Admin@123"
echo "    ⚠️  Change your password immediately after first login!"
