FROM php:8.0-fpm-alpine

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /app

WORKDIR /app
RUN composer install
