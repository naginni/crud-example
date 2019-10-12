# FROM studionone/nginx-php7:latest
FROM php:7.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql

ARG env=production

RUN apt-get update && apt-get install -y \
    git\
    vim \
    sqlite3 \
    wget \
    && wget "http://www.adminer.org/latest.php" -O /var/www/html/adminer.php

# INSTALLING COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && export PATH=/root/composer/vendor/bin:$PATH \
    && composer self-update

WORKDIR /var/www/html
