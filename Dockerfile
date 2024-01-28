FROM composer:lts as deps
WORKDIR /app
RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-interaction

FROM php:8.3.2-fpm-alpine3.19 as final
#RUN apt-get update && apt-get install -y \
#    [package] \
#    [package]
#RUN docker-php-ext-install pdo pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --from=deps --chown=www-data:www-data app/vendor/ /var/www/html/vendor
COPY --chown=www-data:www-data ./src /var/www/html
#USER www-data