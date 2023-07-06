#!/bin/bash

MYSQL_HOST="localhost"
MYSQL_PORT="3306"
MYSQL_USER="root"
MYSQL_PASSWORD=$(cat /home/senri/html/apps/.mysql_password)
MYSQL_DATABASE="app_test01"

/bin/mysql -h $MYSQL_HOST --port=$MYSQL_PORT -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE
