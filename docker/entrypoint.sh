#!/bin/sh
cd /var/www/html

# fix key if needed
if grep -q Change_this_key_or_snipe_will_get_ya app/config/production/app.php
then
  MYSQL_PORT_3306_TCP_ADDR='' MYSQL_PORT_3306_TCP_PORT='' MYSQL_ENV_MYSQL_DATABASE='' \
  MYSQL_ENV_MYSQL_USER='' MYSQL_ENV_MYSQL_PASSWORD='' php artisan --env=production -n key:generate
fi

if [ -f /var/lib/snipeit/ssl/snipeit-ssl.crt -a -f /var/lib/snipeit/ssl/snipeit-ssl.key ]
then
  a2enmod ssl
else
  a2dismod ssl
fi

# create data directories
for dir in 'data/private_uploads' 'data/uploads' 'data/uploads/avatars' 'data/uploads/models' 'data/uploads/suppliers' 'dumps'; do
	mkdir -p "/var/lib/snipeit/$dir"
done

chown -R docker:root /var/lib/snipeit/data/*
chown -R docker:root /var/lib/snipeit/dumps

. /etc/apache2/envvars 
exec apache2 -DNO_DETACH < /dev/null
