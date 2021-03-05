FROM php:7.4-fpm-alpine

ADD ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 timebreaker && adduser -G timebreaker -g timebreaker -s /bin/sh -D timebreaker

RUN mkdir -p /var/www/html

RUN chown timebreaker:timebreaker /var/www/html

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql