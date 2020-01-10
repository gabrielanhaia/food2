#!/bin/bash

set +e

# ANGULAR
sed -i -e "s/APP_ENV/${APP_ENV}/g" /var/www/html/public/public/config.js
sed -i -e "s/VIRTUAL_HOST/${VIRTUAL_HOST}/g" /var/www/html/public/public/config.js

# ADMIN
sed -i -e "s/APP_ENV/${APP_ENV}/g" /var/www/html/public/admin/config.js
sed -i -e "s/VIRTUAL_HOST/${VIRTUAL_HOST}/g" /var/www/html/public/admin/config.js

# Adjust write permissions for www-data
cd /var/www/html
php artisan passport:install

set -e

/entrypoint_php.sh
