#!/bin/bash

# define variables
db_dump="proyecto-2019-03-04.sql"
host="localhost"
db_name="random_gym"
read -p "Nombre de usuario mysql >> " username
read -sp "Contrasena para $username >> " password
page_len=10

# generate a folder with enough permissions to act as bucket
# in order to store updloaded pictures in it
mkdir bucket
chmod -R 777 bucket

# load database dump
mysql --user="$username" --password="$password" --execute="CREATE DATABASE $db_name;"
mysql --user="$username" --password="$password" --database="$db_name" < $db_dump

# generate the configuration file
mv configuracion.php.temp configuracion.php
sed -i -e "s/:host:/$host/g" configuracion.php
sed -i -e "s/:db_name:/$db_name/g" configuracion.php
sed -i -e "s/:username:/$username/g" configuracion.php
sed -i -e "s/:password:/$password/g" configuracion.php
sed -i -e "s/:page_len:/$page_len/g" configuracion.php

# cleanup
unset db_dump
unset host
unset db_name
unset username
unset password
unset page_len

clear
echo "Check out the site entering https://$(hostname -I)"
