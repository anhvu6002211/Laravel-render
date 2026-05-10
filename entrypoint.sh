#!/usr/bin/env bash

# Configure Apache to listen on $PORT instead of 80 (Render provides $PORT)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Start Apache in the foreground
exec apache2-foreground
