#!/bin/bash

set +e

if [ ! -f /initialized ]; then

    # PNP Setup
    if [ ! $APP_ENV = 'local' ]; then
        rm /usr/local/etc/php/conf.d/xdebug.ini
    fi

    echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/laravel-cron
    chmod 0644 /etc/cron.d/laravel-cron
    crontab /etc/cron.d/laravel-cron

    # CREATES LOCK
    touch /initialized

fi;

# Adjust write permissions for www-data
chown -R www-data: /var/www/html

set -e

service php7.3-fpm start
supervisord -c /etc/supervisor/supervisord.conf
service cron start

tail -f /dev/null
