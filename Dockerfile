FROM php:7.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS

COPY ./config/php/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer