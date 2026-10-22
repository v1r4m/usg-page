# PHP2Shell(CVE-2026-109618/109619) 패치 버전 이상으로 고정
ARG PHP_IMAGE=php:8.5.12-fpm-alpine

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative --no-dev

FROM ${PHP_IMAGE} AS app
WORKDIR /var/www/html
# PHP 8.5부터 opcache 내장
RUN { echo 'opcache.enable=1'; echo 'opcache.validate_timestamps=0'; echo 'expose_php=Off'; } > /usr/local/etc/php/conf.d/zz-app.ini
COPY --from=vendor --chown=www-data:www-data /app /var/www/html
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint && rm -f public/hot
USER www-data
ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]

FROM nginx:1.29-alpine AS web
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=vendor /app/public /var/www/html/public
