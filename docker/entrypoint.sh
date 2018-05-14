#!/bin/sh

# fix key if needed
if [ -z "$APP_KEY" ]
then
  echo "Please re-run this container with an environment variable \$APP_KEY"
  echo "An example APP_KEY you could use is: "
  php artisan key:generate --show
  exit
fi

if [ -f /var/lib/snipeit/ssl/snipeit-ssl.crt -a -f /var/lib/snipeit/ssl/snipeit-ssl.key ]
then
  a2enmod ssl
else
  a2dismod ssl
fi

# create data directories
for dir in 'data/private_uploads' 'data/uploads' 'data/uploads/avatars' 'data/uploads/barcodes' 'data/uploads/categories' 'data/uploads/companies' 'data/uploads/departments' 'data/uploads/locations' 'data/uploads/manufacturers' 'data/uploads/models' 'data/uploads/suppliers' 'dumps'; do
	mkdir -p "/var/lib/snipeit/$dir"
done

chown -R docker:root /var/lib/snipeit/data/*
chown -R docker:root /var/lib/snipeit/dumps

. /etc/apache2/envvars 
exec apache2 -DNO_DETACH < /dev/null
