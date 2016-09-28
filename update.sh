#!/bin/bash

######################################################
#           Snipe-It Update Script                   #
#          Script created by Mike Tucker             #
#            mtucker6784@gmail.com                   #
#                                                    #
# Feel free to modify, but please give               #
# credit where it's due. Thanks!                     #
######################################################

# ensure running as root
if [ "$(id -u)" != "0" ]; then
  exec sudo "$0" "$@"
fi
name="snipeit"
gitclone="snipeit"$(date +%s.%S.%m)

if [ -f /etc/lsb-release ]; then
    distro="$(lsb_release -s -i )"
    version="$(lsb_release -s -r)"
elif [ -f /etc/os-release ]; then
    distro="$(. /etc/os-release && echo $ID)"
    version="$(. /etc/os-release && echo $VERSION_ID)"
#Order is important here.  If /etc/os-release and /etc/centos-release exist, we're on centos 7.
#If only /etc/centos-release exist, we're on centos6(or earlier).  Centos-release is less parsable,
#so lets assume that it's version 6 (Plus, who would be doing a new install of anything on centos5 at this point..)
elif [ -f /etc/centos-release ]; then
        distro="Centos"
        version="6"
else
    distro="unsupported"
fi


updatedef () {
  git clone https://github.com/snipe/snipe-it ./$gitclone
  cp -Rfaxv ./$gitclone $installdir
  rm -rf ./$gitclone
  cd $installdir
  php composer.phar install --no-dev --prefer-source
  php composer.phar dump-autoload
  php artisan migrate
  php artisan config:clear
}

updateuser () {
  git clone https://github.com/snipe/snipe-it ./$gitclone
  cp -Rfaxv ./$gitclone $userdir
  rm -rf ./$gitclone
  cd $userdir
  php composer.phar install --no-dev --prefer-source
  php composer.phar dump-autoload
  php artisan migrate
  php artisan config:clear
}

#First things first, let's set some variables and find our distro.
echo "Snipeit unofficial update script ..."

case $distro in
	*Ubuntu*)
		installdir=/var/www/$name
		;;
	*Debian*|*debian*)
		installdir=/var/www/$name
		;;
	*centos*|*redhat*)
		installdir=/var/www/html/$name
		;;
	*)
		echo -e "[ERROR] Sorry, I don't want to assume an update on an install I don't support."
		exit
		;;
esac
echo -e "\n* Grabbing latest git clone version.\n"
if [ -d $installdir ]; then
	updatedef
else
	echo -e "\n\n[NOTICE] Your snipeit install isn't where I thought it'd be ($installdir).\nCare to tell me where it's at?"
	echo -ne "* Install directory [example: $installdir]: "
	read userdir
	if [[ -z $userdir ]]; then
		echo -e "[ERROR] Directory invalid or not found. Exiting.\n\n"
		exit
	fi
	if [ -d $userdir ];
		then
			updateuser
		else
			echo "[ERROR] Directory invalid or not found. Exiting."
			exit
		fi
fi


