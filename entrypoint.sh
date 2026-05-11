#!/usr/bin/env bash
set -e

# Configure Apache to listen on $PORT instead of 80 (Render provides $PORT)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Create SQLite database file if it doesn't exist
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database

# Ensure storage directories exist and have correct permissions
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Bootstrap cache dir
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/bootstrap/cache

# CLEAR all caches completely (no caching - avoids stale cache issues)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear 2>/dev/null || true

# Only cache config (NOT routes - closure routes can't be cached)
php artisan config:cache

# Run database migrations
php artisan migrate --force

echo "=== Entrypoint complete. DB driver: $(php artisan tinker --execute=\"echo config('database.default');\" 2>/dev/null || echo 'unknown') ==="

# Start Apache in the foreground
exec apache2-foreground
