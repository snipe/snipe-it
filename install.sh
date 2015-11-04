#!/bin/bash

######################################################
#           Snipe-It Install Script                  #
#          Script created by Mike Tucker             #
#            mtucker6784@gmail.com                   #
# This script is just to help streamline the         #
# install process for Debian and CentOS              #
# based distributions. I assume you will be          #
# installing as a subdomain on a fresh OS install.   #
# Right now I'm not going to worry about SMTP setup  #
#                                                    #
# Feel free to modify, but please give               #
# credit where it's due. Thanks!                     #
######################################################

# ensure running as root
if [ "$(id -u)" != "0" ]; then
  exec sudo "$0" "$@"
fi
#First things first, let's set some variables and find our distro.
clear

name="snipeit"
si="Snipe-IT"
hostname="$(hostname)"
fqdn="$(hostname --fqdn)"
ans=default
hosts=/etc/hosts
file=master.zip
tmp=/tmp/$name

rm -rf $tmp/
mkdir $tmp

function isinstalled {
  if yum list installed "$@" >/dev/null 2>&1; then
    true
  else
    false
  fi
}


#  Lets find what distro we are using and what version
distro="$(cat /proc/version)"
if grep -q centos <<<$distro; then
	for f in $(find /etc -type f -maxdepth 1 \( ! -wholename /etc/os-release ! -wholename /etc/lsb-release -wholename /etc/\*release -o -wholename /etc/\*version \) 2> /dev/null);
	do
		distro="${f:5:${#f}-13}"
	done;
	if [ "$distro" = "centos" ] || [ "$distro" = "redhat" ]; then
		distro+="$(rpm -q --qf "%{VERSION}" $(rpm -q --whatprovides redhat-release))"
	fi
fi

echo "
	   _____       _                  __________
	  / ___/____  (_)___  ___        /  _/_  __/
	  \__ \/ __ \/ / __ \/ _ \______ / /  / /   
	 ___/ / / / / / /_/ /  __/_____// /  / /    
	/____/_/ /_/_/ .___/\___/     /___/ /_/     
	            /_/                             
"

echo ""
echo ""
echo "  Welcome to Snipe-IT Inventory Installer for Centos and Debian!"
echo ""

case $distro in
        *Ubuntu*|*Debian*)
                echo "  The installer has detected Ubuntu/Debian as the OS."
                distro=debian
                ;;
        *centos6*|*redhat6*)
                echo "  The installer has detected $distro $distVersion as the OS."
                distro=centos6
                ;;
        *centos7*|*redhat7*)
                echo "  The installer has detected $distro $distVersion as the OS."
                distro=centos7
                ;;
        *)
                echo "  The installer was unable to determine your OS. Exiting for safety."
                exit
                ;;
esac

#Get your FQDN.

echo -n "  Q. What is the FQDN of your server? ($fqdn): "
read fqdn
if [ -z "$fqdn" ]; then
        fqdn="$(hostname --fqdn)"
fi
echo "     Setting to $fqdn"
echo ""

#Do you want to set your own passwords, or have me generate random ones?
until [[ $ans == "yes" ]] || [[ $ans == "no" ]]; do
echo -n "  Q. Do you want me to automatically create the snipe database user password? (y/n) "
read setpw

case $setpw in
        [yY] | [yY][Ee][Ss] )
                mysqluserpw="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c16`)"
                ans="yes"
                ;;
        [nN] | [n|N][O|o] )
                echo -n  "  Q. What do you want your snipeit user password to be?"
                read -s mysqluserpw
                echo ""
				ans="no"
                ;;
        *) 		echo "  Invalid answer. Please type y or n"
                ;;
esac
done

#Snipe says we need a new 32bit key, so let's create one randomly and inject it into the file
random32="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c32`)"

#db_setup.sql will be injected to the database during install. 
#Again, this file should be removed, which will be a prompt at the end of the script.
dbsetup=$tmp/db_setup.sql
echo >> $dbsetup "CREATE DATABASE snipeit;"
echo >> $dbsetup "GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"

#Let us make it so only root can read the file. Again, this isn't best practice, so please remove these after the install.
chown root:root $dbsetup
chmod 700 $dbsetup

case $distro in
	debian)
		#####################################  Install for Debian/ubuntu  ##############################################

		webdir=/var/www

		#Update/upgrade Debian/Ubuntu repositories, get the latest version of git.
		apachefile=/etc/apache2/sites-available/$name.conf
		sudo apt-get update ; sudo apt-get -y upgrade ;	sudo apt-get install -y git unzip

		#  Get files and extract to web dir
		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file &> /dev/null
		unzip -qo $tmp/$file -d $tmp/
		cp -R $tmp/snipe-it-master $webdir/$name

		#We already established MySQL root & user PWs, so we dont need to be prompted. Let's go ahead and install Apache, PHP and MySQL.
		sudo DEBIAN_FRONTEND=noninteractive apt-get install -y lamp-server^
		sudo apt-get install -y php5 php5-mcrypt php5-curl php5-mysql php5-gd


		##  TODO make sure apache is set to start on boot and go ahead and start it

		#Enable mcrypt and rewrite
		sudo php5enmod mcrypt
		sudo a2enmod rewrite
		sudo ls -al /etc/apache2/mods-enabled/rewrite.load

		#Create a new virtual host for Apache.
		echo >> $apachefile ""
		echo >> $apachefile ""
		echo >> $apachefile "<VirtualHost *:80>"
		echo >> $apachefile "ServerAdmin webmaster@localhost"
		echo >> $apachefile "    <Directory $webdir/$name/public>"
		echo >> $apachefile "        Require all granted"
		echo >> $apachefile "        AllowOverride All"
		echo >> $apachefile "   </Directory>"
		echo >> $apachefile "    DocumentRoot $webdir/$name/public"
		echo >> $apachefile "    ServerName $fqdn"
		echo >> $apachefile "        ErrorLog "\${APACHE_LOG_DIR}"/error.log"
		echo >> $apachefile "        CustomLog "\${APACHE_LOG_DIR}"/access.log combined"
		echo >> $apachefile "</VirtualHost>"
		echo >> $hosts "127.0.0.1 $hostname $fqdn"
		a2ensite $name.conf

		#Change permissions on directories
		sudo chmod -R 755 $webdir/$name/app/storage
		sudo chmod -R 755 $webdir/$name/app/private_uploads
		sudo chmod -R 755 $webdir/$name/public/uploads
		sudo chown -R www-data:www-data /var/www/
		echo "##  Finished permission changes."

		#Modify the Snipe-It files necessary for a production environment.
		replace "'www.yourserver.com'" "'$hostname'" -- $webdir/$name/bootstrap/start.php
		cp $webdir/$name/app/config/production/database.example.php $webdir/$name/app/config/production/database.php
		replace "'snipeit_laravel'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "'travis'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $webdir/$name/app/config/production/database.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		replace "'false'," "true," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php


		echo "##  Secure Mysql"
		##  TODO make sure mysql is set to start on boot and go ahead and start it

		# Have user set own root password when securing install
		# and just set the snipeit database user at the beginning
		/usr/bin/mysql_secure_installation 

		echo -n "##  Input your MySQL/MariaDB root password: "
		sudo mysql -u root -p < $dbsetup

		#Install / configure composer
		curl -sS https://getcomposer.org/installer | php
		mv composer.phar /usr/local/bin/composer
		cd $webdir/$name/
		composer install --no-dev --prefer-source
		php artisan app:install --env=production

		service apache2 restart
		;;
	centos6 )
		#####################################  Install for Centos/Redhat 6  ##############################################

		webdir=/var/www/html
		apachefile=/etc/httpd/conf.d/$name.conf

		#Allow us to get the mysql engine
		echo ""
		echo "##  Add IUS repo and install mariaDB and a few other packages.";
		mariadbRepo=/etc/yum.repos.d/MariaDB.repo
		touch $mariadbRepo
		echo >> $mariadbRepo "[mariadb]"
		echo >> $mariadbRepo "name = MariaDB"
		echo >> $mariadbRepo "baseurl = http://yum.mariadb.org/10.0/centos7-amd64"
		echo >> $mariadbRepo "gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaD6"
		echo >> $mariadbRepo "gpgcheck=1"
		echo >> $mariadbRepo "enable=1"

		yum -y install wget > /dev/null
		wget -P $tmp/ https://centos6.iuscommunity.org/ius-release.rpm > /dev/null
		rpm -Uvh $tmp/ius-release*.rpm > /dev/null

		#Install PHP and other needed stuff.
		echo "##  Install PHP and other needed stuff";
		PACKAGES="php56u php56u-mysqlnd php56u-bcmath php56u-cli php56u-common php56u-embedded php56u-gd php56u-mbstring php56u-mcrypt httpd mariadb-server git unzip epel-release"
		
        for p in $PACKAGES;do
	        if isinstalled $p;then
				echo " ##" $p "Installed"
			else
				echo -n " ##" $p "Installing... "
				yum -y install $p > /dev/null
			fi
        done;

        echo ""
		echo "##  Download Snipe-IT from github and put it in the web directory.";

		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file &> /dev/null
		unzip -qo $tmp/$file -d $tmp/
		cp -R $tmp/snipe-it-master $webdir/$name

		# Change permissions on directories
		sudo chmod -R 755 $webdir/$name/app/storage
		sudo chmod -R 755 $webdir/$name/app/private_uploads
		sudo chmod -R 755 $webdir/$name/public/uploads
		sudo chown -R apache:apache $webdir/$name

		# Make mariaDB start on boot and restart the daemon
		echo "##  Start the mariaDB server.";
		chkconfig mysqld on
		/sbin/service mysqld restart

		echo "##  Start securing mariaDB server.";
		/usr/bin/mysql_secure_installation 

		#Create the new virtual host in Apache and enable rewrite
		echo "##  Create the new virtual host in Apache.";

		echo >> $apachefile ""
		echo >> $apachefile ""
		echo >> $apachefile "LoadModule rewrite_module modules/mod_rewrite.so"
		echo >> $apachefile ""
		echo >> $apachefile "<VirtualHost *:80>"
		echo >> $apachefile "ServerAdmin webmaster@localhost"
		echo >> $apachefile "    <Directory $webdir/$name/public>"
		echo >> $apachefile "        Require all granted"
		echo >> $apachefile "        AllowOverride All"
		echo >> $apachefile "        Options +Indexes"
		echo >> $apachefile "   </Directory>"
		echo >> $apachefile "    DocumentRoot $webdir/$name/public"
		echo >> $apachefile "    ServerName $fqdn"
		echo >> $apachefile "        ErrorLog /var/log/httpd/snipe.error.log"
		echo >> $apachefile "        CustomLog /var/log/access.log combined"
		echo >> $apachefile "</VirtualHost>"
		
		echo "##  Setup hosts file.";
		echo >> $hosts "127.0.0.1 $hostname $fqdn"

		# Make apache start on boot and restart the daemon
		chkconfig httpd on
		/sbin/service httpd start
	##TODO get timezone and set it in file
		# Set timezone
		# $tzone=$(grep ZONE /etc/sysconfig/clock);

		# if $tzone == 

		#Modify the Snipe-It files necessary for a production environment.
		replace "'www.yourserver.com'" "'$hostname'" -- $webdir/$name/bootstrap/start.php
		cp $webdir/$name/app/config/production/database.example.php $webdir/$name/app/config/production/database.php
		replace "'snipeit_laravel'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "'travis'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $webdir/$name/app/config/production/database.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php

		#Install / configure composer
		cd $webdir/$name
		echo "##  Input your MySQL/MariaDB root password: "
		mysql -u root -p < $dbsetup
		curl -sS https://getcomposer.org/installer | php
		php composer.phar install --no-dev --prefer-source
		php artisan app:install --env=production

#TODO detect if SELinux and firewall are enabled to decide what to do
		#Add SELinux and firewall exception/rules. Youll have to allow 443 if you want ssl connectivity.
		# chcon -R -h -t httpd_sys_script_rw_t $webdir/$name/
		# firewall-cmd --zone=public --add-port=80/tcp --permanent
		# firewall-cmd --reload

		service httpd restart
		;;
	centos7 )
		#####################################  Install for Centos/Redhat 7  ##############################################

		webdir=/var/www/html
		apachefile=/etc/httpd/conf.d/$name.conf

		#Allow us to get the mysql engine
		echo ""
		echo "##  Add IUS repo and install mariaDB and a few other packages.";
		yum -y install wget > /dev/null
		wget -P $tmp/ https://centos7.iuscommunity.org/ius-release.rpm > /dev/null
		rpm -Uvh $tmp/ius-release*.rpm > /dev/null

		#Install PHP and other needed stuff.
		echo "##  Install PHP and other needed stuff";
		PACKAGES="php56u php56u-mysqlnd php56u-bcmath php56u-cli php56u-common php56u-embedded php56u-gd php56u-mbstring php56u-mcrypt httpd mariadb-server git unzip epel-release"
		
        for p in $PACKAGES;do
	        if isinstalled $p;then
				echo " ##" $p "Installed"
			else
				echo -n " ##" $p "Installing... "
				yum -y install $p > /dev/null
			fi
        done;

        echo ""
		echo "##  Download Snipe-IT from github and put it in the web directory.";

		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file &> /dev/null
		unzip -qo $tmp/$file -d $tmp/
		cp -R $tmp/snipe-it-master $webdir/$name

		# Change permissions on directories
		sudo chmod -R 755 $webdir/$name/app/storage
		sudo chmod -R 755 $webdir/$name/app/private_uploads
		sudo chmod -R 755 $webdir/$name/public/uploads
		sudo chown -R apache:apache $webdir/$name
		
		# Make mariaDB start on boot and restart the daemon
		echo "##  Start the mariaDB server.";
		systemctl enable mariadb.service
		systemctl restart mariadb.service

		echo "##  Start securing mariaDB server.";
		/usr/bin/mysql_secure_installation 

		#Create the new virtual host in Apache and enable rewrite
		echo "##  Create the new virtual host in Apache.";

		echo >> $apachefile ""
		echo >> $apachefile ""
		echo >> $apachefile "LoadModule rewrite_module modules/mod_rewrite.so"
		echo >> $apachefile ""
		echo >> $apachefile "<VirtualHost *:80>"
		echo >> $apachefile "ServerAdmin webmaster@localhost"
		echo >> $apachefile "    <Directory $webdir/$name/public>"
		echo >> $apachefile "        Require all granted"
		echo >> $apachefile "        AllowOverride All"
		echo >> $apachefile "        Options +Indexes"
		echo >> $apachefile "   </Directory>"
		echo >> $apachefile "    DocumentRoot $webdir/$name/public"
		echo >> $apachefile "    ServerName $fqdn"
		echo >> $apachefile "        ErrorLog /var/log/httpd/snipe.error.log"
		echo >> $apachefile "        CustomLog /var/log/access.log combined"
		echo >> $apachefile "</VirtualHost>"
		
		echo "##  Setup hosts file.";
		echo >> $hosts "127.0.0.1 $hostname $fqdn"

		# Make apache start on boot and restart the daemon
		systemctl enable httpd.service
		systemctl restart httpd.service
	##TODO get timezone and set it in file
		# Set timezone
		# $tzone=$(grep ZONE /etc/sysconfig/clock);

		# if $tzone == 

		#Modify the Snipe-It files necessary for a production environment.
		replace "'www.yourserver.com'" "'$hostname'" -- $webdir/$name/bootstrap/start.php
		cp $webdir/$name/app/config/production/database.example.php $webdir/$name/app/config/production/database.php
		replace "'snipeit_laravel'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "'travis'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $webdir/$name/app/config/production/database.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'production.yourserver.com'," "'$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php

		#Install / configure composer
		cd $webdir/$name
		echo "##  Input your MySQL/MariaDB root password "
		mysql -u root -p < $dbsetup
		curl -sS https://getcomposer.org/installer | php
		php composer.phar install --no-dev --prefer-source
		php artisan app:install --env=production

#TODO detect if SELinux and firewall are enabled to decide what to do
		#Add SELinux and firewall exception/rules. Youll have to allow 443 if you want ssl connectivity.
		# chcon -R -h -t httpd_sys_script_rw_t $webdir/$name/
		# firewall-cmd --zone=public --add-port=80/tcp --permanent
		# firewall-cmd --reload

		systemctl restart httpd.service
		;;
esac

echo ""
echo "  ***If you want mail capabilities, open $webdir/$name/app/config/production/mail.php and fill out the attributes***"
echo ""
echo "  ***Open http://$fqdn to login to Snipe-IT.***"
echo ""
echo ""
echo "##  Cleaning up..."
rm -rf $tmp/
echo "##  Done!"
sleep 1
