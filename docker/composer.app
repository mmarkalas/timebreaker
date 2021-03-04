FROM composer:2

RUN addgroup -g 1000 timebreaker && adduser -G timebreaker -g timebreaker -s /bin/sh -D timebreaker

WORKDIR /var/www/html