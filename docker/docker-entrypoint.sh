#!/bin/sh

set -eo pipefail;

echo [INFO docker entrypoint] Start script execution

# Generate new app key if none is provided
if [ -z "$APP_KEY" -a -z "$APP_KEY_FILE" ]
then
  echo "Please re-run this container with an environment variable \$APP_KEY"
  echo "An example APP_KEY you could use is: "
  php artisan key:generate --show
  exit
fi

# Directory configuration
rm -rf \
  "/var/www/html/storage/private_uploads" \
  "/var/www/html/public/uploads" \
  "/var/www/html/storage/app/backups"

# Create data directories
for dir in \
  'data/private_uploads' \
  'data/uploads/accessories' \
  'data/uploads/avatars' \
  'data/uploads/barcodes' \
  'data/uploads/categories' \
  'data/uploads/companies' \
  'data/uploads/components' \
  'data/uploads/consumables' \
  'data/uploads/departments' \
  'data/uploads/locations' \
  'data/uploads/manufacturers' \
  'data/uploads/models' \
  'data/uploads/suppliers' \
  'dumps' \
  'keys'
do
  [ ! -d "/var/lib/snipeit/$dir" ] && mkdir -p "/var/lib/snipeit/$dir"
done

# Sync var/lib/snipeit with /var/www/html directory
ln -fs \
  "/var/lib/snipeit/data/private_uploads" "/var/www/html/storage/private_uploads" \
ln -fs \
  "/var/lib/snipeit/data/uploads" "/var/www/html/public/uploads" \
ln -fs \
  "/var/lib/snipeit/dumps" "/var/www/html/storage/app/backups" \
ln -fs \
  "/var/lib/snipeit/keys/oauth-private.key" "/var/www/html/storage/oauth-private.key"

# If the Oauth DB files are not present copy the vendor files over to the db migrations
if [ ! -f "/var/www/html/database/migrations/*create_oauth*" ]
then
  cp -a /var/www/html/vendor/laravel/passport/database/migrations/* /var/www/html/database/migrations/
fi

# Create laravel log file
touch /var/www/html/storage/logs/laravel.log
# Add correct permissions for files and directories
chown www-data:www-data /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data \
  /var/lib/snipeit/data \
  /var/lib/snipeit/dumps \
  /var/lib/snipeit/keys

# Migrate/create database
php artisan migrate --force
# Clear cache files
php artisan config:clear
php artisan config:cache

echo [INFO docker entrypoint] End script execution

exec "$@" 