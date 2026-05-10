#!/usr/bin/env bash
# Exit on error
set -e

echo "Running composer install..."
composer install --no-dev --optimize-autoloader

echo "Caching configuration..."
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force
