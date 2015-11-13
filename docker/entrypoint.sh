#!/bin/sh
cd /var/www/html

# fix key if needed
if grep -q Change_this_key_or_snipe_will_get_ya app/config/production/app.php
then
  MYSQL_PORT_3306_TCP_ADDR='' MYSQL_PORT_3306_TCP_PORT='' MYSQL_ENV_MYSQL_DATABASE='' \
  MYSQL_ENV_MYSQL_USER='' MYSQL_ENV_MYSQL_PASSWORD='' php artisan --env=production -n key:generate
fi

. /etc/apache2/envvars 
exec apache2 -DNO_DETACH < /dev/null
