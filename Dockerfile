FROM composer:lts as prod-deps
#WORKDIR /app
RUN --mount=type=bind,source=./composer.json,target=composer.json \
    --mount=type=bind,source=./composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction

FROM composer:lts as dev-deps
#WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction

# could use php:8.2-fpm instead of alpine image
FROM php:8.3.2-fpm-alpine3.19 as base
# install dependencies, not required as this was designed to be standalone with minimal dependencies but normally web apps have dependencies
# RUN apt-get update && apt-get install -y \
#     [package] \
#     ...
# don't need to install database extensions because we aren't using a database, but normally I'd do this here as most web apps require database connections
#RUN docker-php-ext-install pdo pdo_mysql
COPY --chown=www-data:www-data ./src /var/www/html

FROM base as development
WORKDIR /var/www/html
COPY ./tests /var/www/html/tests
COPY ./phpstan.neon /var/www/html/phpstan.neon
COPY . .
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --from=dev-deps --chown=www-data:www-data app/vendor/ /var/www/html/vendor
COPY --chown=www-data:www-data ./tests /var/www/html/tests
COPY --chown=www-data:www-data ./phpunit.xml /var/www/html

FROM base as final
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=prod-deps --chown=www-data:www-data app/vendor/ /var/www/html/vendor
USER www-data