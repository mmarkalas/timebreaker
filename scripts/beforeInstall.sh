
#!/bin/bash

# get composer, and install to /usr/local/bin
if [ ! -f "/usr/local/bin/composer" ];then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
else
    /usr/local/bin/composer self-update --stable --no-ansi --no-interaction
fi

# create a COMPOSER_HOME directory for the application
if [ ! -d "/var/cache/composer" ];then
    mkdir -p /var/cache/composer
    chown www.www /var/cache/composer
fi