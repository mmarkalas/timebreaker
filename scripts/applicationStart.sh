#!/bin/bash

service httpd start

sudo /usr/local/bin/supervisorctl start es_index:*