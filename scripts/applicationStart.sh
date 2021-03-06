#!/bin/bash

sudo /etc/init.d/nginx start

sudo /etc/init.d/php7.4-fpm start

sudo /usr/local/bin/supervisorctl start es_index:*