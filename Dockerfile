FROM php:8.1-apache

RUN apt update && apt dist-upgrade -y && apt install -y git libzip-dev zip
RUN docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

ADD . /var/www/html

RUN cd /var/www/html/ && composer install