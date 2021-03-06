#!/bin/bash

# Enter html directory
cd /var/www/html/

# Create DATABASE
mysql -u root -e "CREATE DATABASE timebreaker;"

# Create cache and chmod folders
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/public/files/

# Install dependencies
export COMPOSER_ALLOW_SUPERUSER=1
/usr/local/bin/composer install -d /var/www/html/

# Copy configuration from /var/www/.env
sudo cp .env.prod .env

# run key generate
php /var/www/html/artisan key:generate

# Migrate all tables
php /var/www/html/artisan migrate

# generate Swagger UI
php /var/www/html/artisan swagger-lume:generate

# Clear cache
php /var/www/html/artisan cache:clear

# Change rights for storage
chmod 777 -R /var/www/html/storage

cp .env.prod .env

# Fix user rights
sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www/html
sudo chmod 2775 /var/www/html
find /var/www/html -type d -exec sudo chmod 2775 {} \;
find /var/www/html -type f -exec sudo chmod 0664 {} \;