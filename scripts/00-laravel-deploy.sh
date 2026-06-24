#!/usr/bin/env bash
set -e
echo "Installing dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Done — Laravel is ready."
