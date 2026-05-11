#!/usr/bin/env bash
set -e

# TẠM THỜI: bật debug để thấy lỗi thật trên Render
export APP_DEBUG=true

# Configure Apache to listen on $PORT instead of 80 (Render provides $PORT)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Create SQLite database file if it doesn't exist
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

# Ensure storage directories exist and have correct permissions
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/views
chown -R www-data:www-data /var/www/html/storage

# Clear and rebuild caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Seed database with sample data (optional)
# php artisan db:seed --force

# Start Apache in the foreground
exec apache2-foreground
