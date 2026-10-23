# nginx + php-fpm 단일 컨테이너 (Coolify Dockerfile / Docker Compose 빌드팩 둘 다 사용 가능)
# PHP2Shell(CVE-2026-109618/109619) 패치 버전 이상으로 고정
ARG PHP_IMAGE=php:8.5.12-fpm-alpine

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --classmap-authoritative --no-dev

FROM ${PHP_IMAGE}
WORKDIR /var/www/html

ENV APP_NAME=usg-page \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    CACHE_STORE=file \
    SESSION_DRIVER=cookie \
    DB_CONNECTION=sqlite

# PHP 8.5부터 opcache 내장
RUN apk add --no-cache nginx \
    && { echo 'opcache.enable=1'; echo 'opcache.validate_timestamps=0'; echo 'expose_php=Off'; } > /usr/local/etc/php/conf.d/zz-app.ini \
    && rm -f /etc/nginx/http.d/default.conf

COPY docker/nginx.conf /etc/nginx/http.d/app.conf
COPY --from=vendor --chown=www-data:www-data /app /var/www/html
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint && rm -f public/hot

EXPOSE 80
HEALTHCHECK --interval=10s --timeout=3s --retries=5 CMD wget -q -O /dev/null http://127.0.0.1/up || exit 1
ENTRYPOINT ["entrypoint"]
