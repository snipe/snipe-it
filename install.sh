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
si="Snipe-IT"
hostname="$(hostname)"
fqdn="$(hostname --fqdn)"
hosts=/etc/hosts
file=master.zip
webdir=/var/www/html
name="snipeit"
tmp=/tmp/$name
ans=default
mkdir $tmp

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
                distro=redhat6
                ;;
        *centos7*|*redhat7*)
                echo "  The installer has detected $distro $distVersion as the OS."
                distro=redhat7
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
echo -n "  Q. Do you want me to automatically create the MySQL root & user passwords? (y/n) "
read setpw

case $setpw in
        [yY] | [yY][Ee][Ss] )
                mysqlrootpw="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c8`)"
                mysqluserpw="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c8`)"
                echo "  I'm putting this into $tmp/mysqlpasswords ... "
				echo "  PLEASE REMOVE that file after you have recorded the passwords somewhere safe!"
                ans="yes"
                ;;
        [nN] | [n|N][O|o] )
				echo -n  "  Q. What do you want your root PW to be?"
                read -s mysqlrootpw
                echo ""
                echo -n  "  Q. What do you want your snipeit user PW to be?"
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

#createstuff.sql will be injected to the database during install. mysqlpasswords.txt is a file that will contain the root and snipeit user passwords.
#Again, this file should be removed, which will be a prompt at the end of the script.
dbSetup=$tmp/db_setup.sql
passwordfile=$tmp/mysqlpasswords.txt

echo >> $dbSetup "CREATE DATABASE snipeit;"
echo >> $dbSetup "GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"
echo >> $passwordfile "MySQL Passwords..."
echo >> $passwordfile "Root: $mysqlrootpw"
echo >> $passwordfile "User (snipeit): $mysqluserpw"
echo >> $passwordfile "32 bit random string: $random32"

echo "  ************************************************************"
echo "  *  MySQL ROOT password: $mysqlrootpw                           *"
echo "  *  MySQL USER (snipeit) password: $mysqluserpw                 *"
echo "  *  32 bit random string: $random32  *"
echo "  ************************************************************"
echo ""
echo "  These passwords have been exported to $tmp/mysqlpasswords.txt..."
echo "  I recommend You delete this file for security purposes"
echo ""

#Let us make it so only root can read the file. Again, this isn't best practice, so please remove these after the install.
chown root:root $passwordfile $creatstufffile
chmod 700 $passwordfile $createstufffile

case $distro in
	debian)
		#####################################  Install for Debian/ubuntu  ##############################################

		#Update/upgrade Debian/Ubuntu repositories, get the latest version of git.
		apachefile=/etc/apache2/sites-available/$fqdn.conf
		sudo apt-get update ; sudo apt-get -y upgrade ;	sudo apt-get install -y git unzip

		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file
		sudo unzip $file -d /var/www/

		#We already established MySQL root & user PWs, so we dont need to be prompted. Let's go ahead and install Apache, PHP and MySQL.
		sudo DEBIAN_FRONTEND=noninteractive apt-get install -y lamp-server^
		sudo apt-get install -y php5 php5-mcrypt php5-curl php5-mysql php5-gd

		#Create MySQL accounts
		echo "##  Create MySQL accounts"
		sudo mysqladmin -u root password $mysqlrootpw
		sudo mysql -u root -p$mysqlrootpw < $tmp/createstuff.sql

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
		a2ensite $fqdn.conf

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
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		replace "'false'," "true," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php

		#Install / configure composer
		curl -sS https://getcomposer.org/installer | php
		mv composer.phar /usr/local/bin/composer
		cd $webdir/$name/
		composer install --no-dev --prefer-source
		php artisan app:install --env=production

		service apache2 restart
		;;
	redhat6 )
		#####################################  Install for Centos/Redhat 6  ##############################################

		#Make directories so we can create a new apache vhost
		apachefile=/etc/httpd/conf.d/snipe-it.conf

		#Allow us to get the mysql engine
		echo "##  Add IUS repo and install mariaDB and a few other packages.";
		mariadbRepo=/etc/yum.repos.d/MariaDB.repo
		touch $mariadbRepo
		echo >> $mariadbRepo "[mariadb]"
		echo >> $mariadbRepo "name = MariaDB"
		echo >> $mariadbRepo "baseurl = http://yum.mariadb.org/10.0/centos7-amd64"
		echo >> $mariadbRepo "gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB"
		echo >> $mariadbRepo "gpgcheck=1"
		echo >> $mariadbRepo "enable=1"

		wget -P $tmp/ https://centos6.iuscommunity.org/ius-release.rpm

		rpm -Uvh ius-release*.rpm > /dev/null
		yum -y install httpd mariadb-server wget git unzip epel-release > /dev/null

		echo "##  Download Snipe-IT from github and put it in the web directory.";

		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file &> /dev/null
		unzip -qo $tmp/master.zip -d $tmp/
		cp -R $tmp/snipe-it-master $webdir/$name

		# Change permissions on directories
		sudo chmod -R 755 $webdir/$name/app/storage
		sudo chmod -R 755 $webdir/$name/app/private_uploads
		sudo chmod -R 755 $webdir/$name/public/uploads
		sudo chown -R apache:apache $webdir/$name


		# Makde mariaDB start on boot and restart the daemon
		echo "##  Start the mariaDB server.";
		chkconfig mysqld on
		/sbin/service mysqld restart

		# Have user set own root password when securing install
		# and just set the snipeit database user at the beginning
		/usr/bin/mysql_secure_installation 

		#Create MySQL accounts
		# echo "##  Create MySQL accounts"
		# mysqladmin -u root password $mysqlrootpw
		# echo ""
		# echo "  ***Your Current ROOT password is---> $mysqlrootpw"
		# echo "  ***Use $mysqlrootpw at the following prompt for root login***"
		# echo ""		

		#Install PHP stuff.
		echo "##  Install PHP Stuff";
		PACKAGES="php56u php56u-mysqlnd php56u-bcmath php56u-cli php56u-common php56u-embedded php56u-gd php56u-mbstring php56u-mcrypt"
		
		yum -y install $PACKAGES  > /dev/null
		rpm --query --queryformat "    " $PACKAGES

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

		#Modify the Snipe-It files necessary for a production environment.
		replace "'www.yourserver.com'" "'$hostname'" -- $webdir/$name/bootstrap/start.php
		cp $webdir/$name/app/config/production/database.example.php $webdir/$name/app/config/production/database.php
		replace "'snipeit_laravel'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "'travis'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $webdir/$name/app/config/production/database.php
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php

		#Install / configure composer
		cd $webdir/$name
		mysql -u root -p < $tmp/createstuff.sql
		curl -sS https://getcomposer.org/installer | php
		php composer.phar install --no-dev --prefer-source
		php artisan app:install --env=production

		#Add SELinux and firewall exception/rules. You'll have to allow 443 if you want ssl connectivity.
		# chcon -R -h -t httpd_sys_script_rw_t $webdir/$name/
		# firewall-cmd --zone=public --add-port=80/tcp --permanent
		# firewall-cmd --reload

		service httpd restart
		;;
	redhat7 )
		#####################################  Install for Centos/Redhat 7  ##############################################

		#Make directories so we can create a new apache vhost
		apachefile=/etc/httpd/conf.d/snipe-it.conf

		#Allow us to get the mysql engine
		echo "##  Add IUS repo and install mariaDB and a few other packages.";
		wget -P $tmp/ https://centos7.iuscommunity.org/ius-release.rpm
		rpm -Uvh ius-release.rpm > /dev/null
		yum -y install httpd mariadb-server wget git unzip epel-release > /dev/null

		echo "##  Download Snipe-IT from github and put it in the web directory.";

		wget -P $tmp/ https://github.com/snipe/snipe-it/archive/$file &> /dev/null
		unzip -qo $tmp/master.zip -d $tmp/
		cp -R $tmp/snipe-it-master $webdir/$name

		# Change permissions on directories
		sudo chmod -R 755 $webdir/$name/app/storage
		sudo chmod -R 755 $webdir/$name/app/private_uploads
		sudo chmod -R 755 $webdir/$name/public/uploads
		sudo chown -R apache:apache $webdir/$name
		
		echo "##  Start the mariaDB server.";
		#/sbin/service mysqld start
		# Makde mariaDB start on boot and restart the daemon
		systemctl enable mariadb.service
		systemctl restart mariadb.service

		# Have user set own root password when securing install
		# and just set the snipeit database user at the beginning
		/usr/bin/mysql_secure_installation 

		#Create MySQL accounts
		# echo "##  Create MySQL accounts"
		# mysqladmin -u root password $mysqlrootpw
		# echo ""
		# echo "  ***Your Current ROOT password is---> $mysqlrootpw"
		# echo "  ***Use $mysqlrootpw at the following prompt for root login***"
		# echo ""		

		#Install PHP stuff.
		echo "##  Install PHP Stuff";
		PACKAGES="php56u php56u-mysqlnd php56u-bcmath php56u-cli php56u-common php56u-embedded php56u-gd php56u-mbstring php56u-mcrypt"
		
		yum -y install $PACKAGES  > /dev/null
		rpm --query --queryformat "    " $PACKAGES

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

		#Modify the Snipe-It files necessary for a production environment.
		replace "'www.yourserver.com'" "'$hostname'" -- $webdir/$name/bootstrap/start.php
		cp $webdir/$name/app/config/production/database.example.php $webdir/$name/app/config/production/database.php
		replace "'snipeit_laravel'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "'travis'," "'snipeit'," -- $webdir/$name/app/config/production/database.php
		replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $webdir/$name/app/config/production/database.php
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/database.php
		cp $webdir/$name/app/config/production/app.example.php $webdir/$name/app/config/production/app.php
		replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $webdir/$name/app/config/production/app.php
		replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $webdir/$name/app/config/production/app.php
		cp $webdir/$name/app/config/production/mail.example.php $webdir/$name/app/config/production/mail.php

		#Install / configure composer
		cd $webdir/$name
		mysql -u root -p < $tmp/createstuff.sql
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
echo "  ***I have no idea about your mail environment, so if you want email capability, open up the following***"
echo "  nano -w $webdir/$name/app/config/production/mail.php"
echo "  And edit the attributes appropriately."
echo ""
sleep 1

echo ""
echo "  ***If you want mail capabilities, open $webdir/$name/app/config/production/mail.php and fill out the attributes***"
echo ""
echo "  ***$si should now be installed. open up http://$fqdn in a web browser to verify.***"
echo ""
echo ""
echo "##  Cleaning up..."
rm -rf $tmp/
echo "##  Done!"
sleep 1
