FROM php:8.2-apache

RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y zip unzip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN composer install

COPY . ./

RUN a2enmod rewrite
