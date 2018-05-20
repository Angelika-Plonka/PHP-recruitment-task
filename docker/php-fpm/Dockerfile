FROM php:7.1.5-fpm

RUN apt-get update && buildDeps="libpq-dev libzip-dev libfreetype6-dev libjpeg62-turbo-dev libpng12-dev" && apt-get install -y $buildDeps git nano wget --no-install-recommends
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath

RUN wget https://getcomposer.org/composer.phar && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

COPY upload.ini /usr/local/etc/php/conf.d/upload.ini
COPY date.ini /usr/local/etc/php/conf.d/date.ini

WORKDIR /app