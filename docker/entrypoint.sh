#!/bin/bash
set -e

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

until php artisan db:monitor --databases=mysql > /dev/null 2>&1; do
    sleep 2
done

php artisan migrate --force --no-interaction
php artisan storage:link 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php-fpm
