#!/bin/bash

# load global environment variables and specific to target
APP_ENV=dev
APP_NAME=test
DOMAIN_NAME=.acme
VIRTUAL_HOST=${APP_NAME}${DOMAIN_NAME}

DEV_ENVFILE=`pwd`/docker/dev.env

cp `pwd`/docker/template.env ${DEV_ENVFILE}

sed -i -e "s/___APP_NAME___/${APP_NAME}/g" ${DEV_ENVFILE}
sed -i -e "s/___VIRTUAL_HOST___/${VIRTUAL_HOST}/g" ${DEV_ENVFILE}
sed -i -e "s/___DOMAIN_NAME___/${DOMAIN_NAME}/g" ${DEV_ENVFILE}

source ${DEV_ENVFILE}
# If you are running on Mac, we won't want to do a fresh checkout everytime
if [ -f /c/Windows/System32/drivers/etc/hosts ] ; then
    echo 'Seems like you are running cygwin bash on Windows with docker for windows.'
    NEWLINE=$'\r\n'
    HOSTS_PATH=/c/Windows/System32/drivers/etc/hosts
    export COMPOSE_CONVERT_WINDOWS_PATHS=1
    sudobin=''
elif [ -f /mnt/c/Windows/System32/drivers/etc/hosts ] ; then
    echo 'Seems like you are running Windows Linux Subsystem. Make sure you have docker installed on your Linux Subsystem and it does not conflict with Docker for Windows'
    NEWLINE=$'\r\n'
    HOSTS_PATH=/mnt/c/Windows/System32/drivers/etc/hosts
    export COMPOSE_CONVERT_WINDOWS_PATHS=1
    sudobin=''
else
    HOSTS_PATH=/etc/hosts
    sudobin=sudo
fi;

# Setup DNS for environment only once (entries to /etc/hosts/)
# If you have error about the bellow error like "./setup.sh: line 70: [: too man You ny arguments", it's not an error
if [[ ! `grep "$VIRTUAL_HOST" "$HOSTS_PATH"` ]]; then
    echo 'Adding DNS entries';
    echo $sudobin sh -c "echo '${NEWLINE}127.0.0.1 ${VIRTUAL_HOST}' >> ${HOSTS_PATH}";
    $sudobin sh -c "echo '${NEWLINE}127.0.0.1 ${VIRTUAL_HOST}' >> ${HOSTS_PATH}";
fi;

if [ ! -f `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.key ]; then

    echo "Generating fake cert keys for $VIRTUAL_HOST"

    cp `pwd`/docker/proxy/ssl_certs/openssl.cnf `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.cnf
    sed -i -e "s/DOMAIN_NAME/$DOMAIN_NAME/g" `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.cnf
    sed -i -e "s/HOSTNAME/$VIRTUAL_HOST/g" `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.cnf
    openssl genrsa -out `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.key 2048
    openssl req -new -out `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.csr \
        -key `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.key \
        -config `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.cnf
    openssl x509 -req -sha256 -days 365 -in `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.csr \
        -signkey `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.key \
        -out `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.crt \
        -extensions v3_req \
        -extfile `pwd`/docker/proxy/ssl_certs/$VIRTUAL_HOST.cnf

fi;

# Register the certificates in the environment
if [[ `uname` = 'Darwin' ]]; then

    echo "Macbook SSL Certs"

elif [[ `uname` = 'Linux' ]]; then

    if [ -f /c/Windows/System32/drivers/etc/hosts ] ; then
        echo "Windows 1 SSL Certs"
    elif [ -f /mnt/c/Windows/System32/drivers/etc/hosts ] ; then
        echo "Windows 2 SSL Certs"
    else
        echo "Linux SSL Certs (we need to run this with SUDO, so, provide your password, please)"
        sudo cp docker/proxy/ssl_certs/*.crt /usr/local/share/ca-certificates/
        sudo update-ca-certificates
    fi
fi;

#config.js copy
echo "cp ../docker/configs/frontend/admin/config.js ../src/public/admin"
cp ../docker/configs/frontend/admin/config.js ../src/public/admin
echo "cp ../docker/configs/frontend/web/config.js ../src/public/web"
cp ../docker/configs/frontend/web/config.js ../src/public/web

# to do a full clean setup removing garbage left by accident
docker stop ${APP_NAME}_proxy_1 ${APP_NAME}_jobs_1 ${APP_NAME}_platform_1 # ${APP_NAME}_mysql_1
docker rm ${APP_NAME}_proxy_1 ${APP_NAME}_jobs_1 ${APP_NAME}_platform_1 # ${APP_NAME}_mysql_1

docker network create $APP_NAME

docker pull threadable/linuxbase
docker pull threadable/nginxbase
docker pull threadable/nginxphpbase

APP_NAME=$APP_NAME VIRTUAL_HOST=$VIRTUAL_HOST DOMAIN_NAME=$DOMAIN_NAME DEV_ENVFILE=${DEV_ENVFILE} \
    docker-compose -f `pwd`/docker/base.yml -p $APP_NAME up -d --build;

APP_NAME=$APP_NAME VIRTUAL_HOST=$VIRTUAL_HOST DOMAIN_NAME=$DOMAIN_NAME DEV_ENVFILE=${DEV_ENVFILE} \
    docker-compose -f `pwd`/docker/app.yml -p $APP_NAME up -d --build;

# Final steps to get php artisan and phunit to work outside of the container too
cp $DEV_ENVFILE ../src/.env
sed -i -e "s/${APP_NAME}_mysql_1/127.0.0.1/g" ../src/.env

#Final setup on API
echo "Adding tools for the developer in the containers"
docker exec ${APP_NAME}_platform_1 bash -c "apt-get update"
docker exec ${APP_NAME}_platform_1 bash -c "apt-get install -y --allow-unauthenticated --fix-missing --no-install-recommends inetutils-tools inetutils-ping net-tools git curl vim ssh wget dos2unix git unzip"
docker exec ${APP_NAME}_platform_1 bash -c "curl -s http://getcomposer.org/installer | php  && mv composer.phar /usr/local/bin/composer";
docker exec ${APP_NAME}_platform_1 bash -c "cd /var/www/html && composer install";
echo 'Taking a rest - trying to make sure that local MySQL is fine'
sleep 3;
docker exec ${APP_NAME}_platform_1 bash -c "cd /var/www/html && php artisan auditing:install && php artisan migrate && php artisan passport:install";

#Final setup on WWW
docker exec ${APP_NAME}_platform_1 bash -c "apt-get update && apt-get upgrade -y"
docker exec ${APP_NAME}_platform_1 bash -c "apt-get install -y --allow-unauthenticated --fix-missing --no-install-recommends git nodejs npm"
docker exec ${APP_NAME}_platform_1 bash -c "cd /var/www/html && npm install -g gulp -y && npm install gulp lodash gulp-version-number -y && npm install -g bower --allow-root"
docker exec ${APP_NAME}_platform_1 bash -c "cd /var/www/html/public && bower install --allow-root";

echo "Access now https://${VIRTUAL_HOST} to see your environment";

exit 0;
