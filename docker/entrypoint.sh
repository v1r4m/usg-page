#!/bin/sh
set -e

: "${APP_KEY:?APP_KEY 환경 변수가 필요합니다}"

php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache

php-fpm -D
exec nginx -g 'daemon off;'
