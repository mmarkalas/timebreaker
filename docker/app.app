FROM php:7.4-fpm-alpine

# lumen/laravel packages
RUN docker-php-ext-install tokenizer mysqli pdo pdo_mysql pcntl
