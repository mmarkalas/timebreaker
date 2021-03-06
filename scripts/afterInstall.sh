#!/bin/bash

# Enter html directory
cd /var/www/html/

# Create DATABASE
mysql -u root -e "CREATE DATABASE timebreaker;"

# Create cache and chmod folders
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/public/files/

# Fix user rights
sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www/html
sudo chmod 2775 /var/www/html
find /var/www/html -type d -exec sudo chmod 2775 {} \;
find /var/www/html -type f -exec sudo chmod 0664 {} \;

# Install dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer install -d /var/www/html/

# Create Cert and Copy SSL configuration 
yum -y install mod_ssl
sudo /etc/pki/tls/certs/make-dummy-cert localhost.crt
sudo cp /var/www/html/scripts/ssl.conf /etc/httpd/conf.d/ssl.conf

# Hide Server Details except for Product (Apache) in Headers
sudo cp /var/www/html/scripts/secure.conf /etc/httpd/conf.d/secure.conf

# Hide PHP in Headers
sudo cp /var/www/html/scripts/hidephp.ini /etc/php.d/hidephp.ini 

# Restart Apache
sudo service httpd restart

# Copy configuration from /var/www/.env
cp .env.prod .env

# run key generate
php /var/www/html/artisan key:generate -f

# Migrate all tables
php /var/www/html/artisan migrate:refresh -f

# generate Swagger UI
php /var/www/html/artisan swagger-lume:generate

# Clear cache
php /var/www/html/artisan cache:clear

# Change rights for storage
chmod 775 -R /var/www/html/storage
