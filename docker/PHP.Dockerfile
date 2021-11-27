FROM php:fpm

RUN docker-php-ext-install pdo 

COPY . /app

WORKDIR "/app"
