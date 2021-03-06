#!/bin/bash

# go to app directory
cd /var/www/html

# run composer
COMPOSER_HOME=/var/cache/composer composer install

# run key generate
php artisan key:generate

# run migrations
php artisan migrate

# generate Swagger UI
php artisan swagger-lume:generate