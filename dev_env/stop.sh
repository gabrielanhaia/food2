#!/bin/bash
APP_NAME=test
docker stop ${APP_NAME}_proxy_1 ${APP_NAME}_jobs_1 ${APP_NAME}_platform_1 ${APP_NAME}_mysql_1
