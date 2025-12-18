FROM php:8.3-apache

RUN apt-get update -y \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql