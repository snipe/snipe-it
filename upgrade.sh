#  This is a script to upgrade snipeit
#  Written by: Walter Wahlstedt

# ensure running as root
if [ "$(id -u)" != "0" ]; then
  exec sudo "$0" "$@"
fi
clear
# Set this to your github username to pull your changes ** Only for Devs **
fork='snipe'
#  Set this to the branch you want to pull  ** Only for Devs **
branch='develop'

file=$branch'.zip'

name='snipeit'
webdir=/var/www/html
tmp=/tmp/$name

echo 'Beginning the snipeit update process.'
echo ""

echo 'Setting up temp directory.'
rm -rf $tmp
mkdir $tmp

echo "Getting update."

wget -P $tmp/ https://github.com/$fork/snipe-it/archive/$file >> /var/log/snipeit-update.log 2>&1 

echo "Applying update files."

unzip -qo $tmp/$file -d $tmp/
cp -Ru $tmp/snipe-it-$branch/* $webdir/$name
cd /var/www/html/snipeit

echo "Running composer to apply update."
echo ""
sudo php composer.phar install --no-dev --prefer-source
sudo php composer.phar dump-autoload
sudo php artisan migrate