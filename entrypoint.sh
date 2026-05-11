#!/usr/bin/env bash
set -e

# Configure Apache to listen on $PORT instead of 80 (Render provides $PORT)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Clear and rebuild caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
# We force SESSION_DRIVER=array during migration to avoid issues if the sessions table is missing
SESSION_DRIVER=array php artisan migrate --force
# php artisan db:seed --force

# Start Apache in the foreground
exec apache2-foreground
