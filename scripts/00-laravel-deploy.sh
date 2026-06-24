#!/usr/bin/env bash
# Run during container startup by richarvey/nginx-php-fpm (RUN_SCRIPTS=1)
set -e

echo "==> Setting storage permissions..."
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Caching config..."
php artisan config:cache

echo "==> Caching routes..."
php artisan route:cache

echo "==> Running migrations and seeders..."
php artisan migrate --force --seed || echo "WARNING: Migration failed — DB may not be reachable yet."

echo "==> Done — Laravel is ready."
