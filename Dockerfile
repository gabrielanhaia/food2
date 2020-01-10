FROM threadable/nginxphpbase:2.0.0

ARG SRC_FOLDER=./src

EXPOSE 80

# UBUNTU BASIC SETUP
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
RUN echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

# CREATE START SCRIPTS
COPY ./docker/entrypoint_scripts/entrypoint_platform.sh /entrypoint_platform.sh
RUN chmod 755 /entrypoint_platform.sh

COPY ./docker/entrypoint_scripts/entrypoint_jobs.sh /entrypoint_jobs.sh
RUN chmod 755 /entrypoint_jobs.sh

# API and JOBS SETUP
COPY ./docker/configs/backend/laravel.ini /etc/php/7.3/fpm/conf.d/99-laravel.ini
COPY ./docker/configs/backend/laravel.pool.conf /etc/php/7.3/fpm/pool.d/www.conf
COPY ./docker/configs/backend/jobs/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# FRONTEND CONFIGS
COPY ./docker/configs/frontend/admin/config.js /var/www/html/public/admin/config.js
COPY ./docker/configs/frontend/web/config.js /var/www/html/public/web/config.js

# NGINX SETUP
COPY ./docker/configs/backend/api/nginx.conf /etc/nginx/sites-enabled/default

# Bitbucket keys
COPY ./docker/configs/backend/composer_auth.json /root/.composer/auth.json

# Set container content for publishing
WORKDIR /var/www/html
COPY --chown=www-data:www-data ${SRC_FOLDER} /var/www/html
