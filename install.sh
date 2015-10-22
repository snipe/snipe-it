#!/bin/bash -e

######################################################
# 	    Snipe-It Install Script    	             #
#	   Script created by Mike Tucker             #
#	     mtucker6784@gmail.com                   #
# This script is just to help streamline the         #
# install process for Debian and CentOS              #
# based distributions. I assume you will be          #
# installing as a subdomain on a fresh OS install.   #
# Right now I'm not going to worry about SMTP setup  #
#                                                    #
# Feel free to modify, but please give               #
# credit where it's due. Thanks!                     #
######################################################

#First things first, let's set some variables and find our distro.
clear
si="Snipe-IT"
hostname="$(hostname)"
hosts=/etc/hosts
distro="$(cat /proc/version)"
file=master.zip
dir=/var/www/snipe-it-master

ans=default
case $distro in
        *Ubuntu*|*Debian*)
                echo "Ubuntu/Debian detected. Carry forth."
                distro=u
                ;;
        *centos*)
                echo "CentOS detected. Carry forth."
                distro=c
                ;;
        *)
                echo "Not sure of this OS. Exiting for safety."
		exit
                ;;
esac

#Get your FQDN.
echo ""
echo "$si install script - Installing $ans"
echo "Q. What is the FQDN of your server? (example: www.yourserver.com)"
read fqdn
echo ""

#Do you want to set your own passwords, or have me generate random ones?
ans=default
until [[ $ans == "yes" ]] || [[ $ans == "no" ]]; do
echo "Q. Do you want me to automatically create the MySQL root & user passwords? (y/n)"
read setpw

case $setpw in
        [yY] | [yY][Ee][Ss] )
                mysqlrootpw="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c8`)"
                mysqluserpw="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c8`)"
                echo "I'm putting this into /root/mysqlpasswords ... PLEASE REMOVE that file after you have recorded the passwords somewhere safe!"
                ans="yes"
                ;;
        [nN] | [n|N][O|o] )
		echo "Q. What do you want your root PW to be?"
                read mysqlrootpw
                echo "Q. What do you want your snipeit user PW to be?"
                read mysqluserpw
				ans="no"
                ;;
        *) echo "Invalid answer. Please type y or n"
                ;;
esac
done

#Snipe says we need a new 32bit key, so let's create one randomly and inject it into the file
random32="$(echo `< /dev/urandom tr -dc _A-Za-z-0-9 | head -c32`)"

#createstuff.sql will be injected to the database during install. mysqlpasswords.txt is a file that will contain the root and snipeit user passwords.
#Again, this file should be removed, which will be a prompt at the end of the script.
createstufffile=/root/createstuff.sql
passwordfile=/root/mysqlpasswords.txt

echo >> $createstufffile "CREATE DATABASE snipeit;"
echo >> $createstufffile "GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"
echo >> $passwordfile "MySQL Passwords..."
echo >> $passwordfile "Root: $mysqlrootpw"
echo >> $passwordfile "User (snipeit): $mysqluserpw"
echo >> $passwordfile "32 bit random string: $random32"
echo "MySQL ROOT password: $mysqlrootpw"
echo "MySQL USER (snipeit) password: $mysqluserpw"
echo "32 bit random string: $random32"
echo "These passwords have been exported to /root/mysqlpasswords.txt...I recommend You delete this file for security purposes"

#Let us make it so only root can read the file. Again, this isn't best practice, so please remove these after the install.
chown root:root $passwordfile $creatstufffile
chmod 700 $passwordfile $createstufffile

if [[ $distro == "u" ]]; then
#Update/upgrade Debian/Ubuntu repositories, get the latest version of git.
	apachefile=/etc/apache2/sites-available/$fqdn.conf
	sudo apt-get update ; sudo apt-get -y upgrade ;	sudo apt-get install -y git unzip

	wget https://github.com/snipe/snipe-it/archive/$file
	sudo unzip $file -d /var/www/

	#We already established MySQL root & user PWs, so we dont need to be prompted. Let's go ahead and install Apache, PHP and MySQL.
	sudo DEBIAN_FRONTEND=noninteractive apt-get install -y lamp-server^
	sudo apt-get install -y php5 php5-mcrypt php5-curl php5-mysql php5-gd

	#Create MySQL accounts
	echo "Create MySQL accounts"
	sudo mysqladmin -u root password $mysqlrootpw
	sudo mysql -u root -p$mysqlrootpw < /root/createstuff.sql

	#Enable mcrypt and rewrite
	sudo php5enmod mcrypt
	sudo a2enmod rewrite
	sudo ls -al /etc/apache2/mods-enabled/rewrite.load

	#Create a new virtual host for Apache.
	echo >> $apachefile ""
	echo >> $apachefile ""
	echo >> $apachefile "<VirtualHost *:80>"
	echo >> $apachefile "ServerAdmin webmaster@localhost"
	echo >> $apachefile "    <Directory $dir/public>"
	echo >> $apachefile "        Require all granted"
	echo >> $apachefile "        AllowOverride All"
	echo >> $apachefile "   </Directory>"
	echo >> $apachefile "    DocumentRoot $dir/public"
	echo >> $apachefile "    ServerName $fqdn"
	echo >> $apachefile "        ErrorLog "\${APACHE_LOG_DIR}"/error.log"
	echo >> $apachefile "        CustomLog "\${APACHE_LOG_DIR}"/access.log combined"
	echo >> $apachefile "</VirtualHost>"
	echo >> $hosts "127.0.0.1 $hostname $fqdn"
	a2ensite $fqdn.conf

	#Change permissions on directories
	sudo chmod -R 755 $dir/app/storage
	sudo chmod -R 755 $dir/app/private_uploads
	sudo chmod -R 755 $dir/public/uploads
	sudo chown -R www-data:www-data /var/www/
	echo "Finished permission changes."

	#Modify the Snipe-It files necessary for a production environment.
	replace "'www.yourserver.com'" "'$hostname'" -- $dir/bootstrap/start.php
	cp $dir/app/config/production/database.example.php $dir/app/config/production/database.php
	replace "'snipeit_laravel'," "'snipeit'," -- $dir/app/config/production/database.php
	replace "'travis'," "'snipeit'," -- $dir/app/config/production/database.php
	replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $dir/app/config/production/database.php
	replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $dir/app/config/production/database.php
	cp $dir/app/config/production/app.example.php $dir/app/config/production/app.php
	replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $dir/app/config/production/app.php
	replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $dir/app/config/production/app.php
	replace "'false'," "true," -- $dir/app/config/production/app.php
	cp $dir/app/config/production/mail.example.php $dir/app/config/production/mail.php

	#Install / configure composer
	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer
	cd $dir/
	composer install --no-dev --prefer-source
	php artisan app:install --env=production

	service apache2 restart
else

	#Make directories so we can create a new apache vhost
	sudo mkdir /etc/httpd/
	sudo mkdir /etc/httpd/sites-available/
	sudo mkdir /etc/httpd/sites-enabled/
	apachefile=/etc/httpd/sites-available/$fqdn.conf
	apachefileen=/etc/httpd/sites-enabled/$fqdn.conf
	apachecfg=/etc/httpd/conf/httpd.conf

	#Allow us to get the mysql engine
	sudo rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
	sudo yum -y install httpd mysql-server wget git unzip

	wget https://github.com/snipe/snipe-it/archive/$file
	sudo unzip $file -d /var/www/

	sudo /sbin/service mysqld start

	#Create MySQL accounts
	echo "Create MySQL accounts"
	sudo mysqladmin -u root password $mysqlrootpw
	echo ""
	echo "***Your Current ROOT password is---> $mysqlrootpw"
	echo "***Use $mysqlrootpw at the following prompt for root login***"
	sudo /usr/bin/mysql_secure_installation

	#Install PHP stuff.
	sudo yum -y install php php-mysql php-bcmath.x86_64 php-cli.x86_64 php-common.x86_64 php-embedded.x86_64 php-gd.x86_64 php-mbstring
	wget http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
	rpm -ivh epel-release-7-5.noarch.rpm
	yum install -y --enablerepo="epel" php-mcrypt

	#Create the new virtual host in Apache.
	echo >> $apachefile ""
	echo >> $apachefile ""
	echo >> $apachefile "<VirtualHost *:80>"
	echo >> $apachefile "ServerAdmin webmaster@localhost"
	echo >> $apachefile "    <Directory $dir/public>"
	echo >> $apachefile "        Require all granted"
	echo >> $apachefile "        AllowOverride All"
	echo >> $apachefile "        Options +Indexes"
	echo >> $apachefile "   </Directory>"
	echo >> $apachefile "    DocumentRoot $dir/public"
	echo >> $apachefile "    ServerName $fqdn"
	echo >> $apachefile "        ErrorLog /var/log/httpd/snipe.error.log"
	echo >> $apachefile "        CustomLog /var/log/access.log combined"
	echo >> $apachefile "</VirtualHost>"
	echo >> $hosts "127.0.0.1 $hostname $fqdn"
	sudo ln -s $apachefile $apachefileen

	#Enable rewrite and vhost
	echo >> $apachecfg "LoadModule rewrite_module modules/mod_rewrite.so"
	echo >> $apachecfg "IncludeOptional sites-enabled/*.conf"

	#Change permissions on directories
	sudo chmod -R 755 $dir/app/storage
	sudo chmod -R 755 $dir/app/private_uploads
	sudo chmod -R 755 $dir/public/uploads
	sudo chown -R apache:apache /var/www/

	service httpd restart

	#Modify the Snipe-It files necessary for a production environment.
	replace "'www.yourserver.com'" "'$hostname'" -- $dir/bootstrap/start.php
	cp $dir/app/config/production/database.example.php $dir/app/config/production/database.php
	replace "'snipeit_laravel'," "'snipeit'," -- $dir/app/config/production/database.php
	replace "'travis'," "'snipeit'," -- $dir/app/config/production/database.php
	replace "            'password'  => ''," "            'password'  => '$mysqluserpw'," -- $dir/app/config/production/database.php
	replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $dir/app/config/production/database.php
	cp $dir/app/config/production/app.example.php $dir/app/config/production/app.php
	replace "'http://production.yourserver.com'," "'http://$fqdn'," -- $dir/app/config/production/app.php
	replace "'Change_this_key_or_snipe_will_get_ya'," "'$random32'," -- $dir/app/config/production/app.php
	cp $dir/app/config/production/mail.example.php $dir/app/config/production/mail.php

	#Install / configure composer
	cd $dir
	sudo mysql -u root -p$mysqlrootpw < /root/createstuff.sql
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install --no-dev --prefer-source
	php artisan app:install --env=production

	#Add SELinux and firewall exception/rules. You'll have to allow 443 if you want ssl connectivity.
	chcon -R -h -t httpd_sys_script_rw_t $dir/
	firewall-cmd --zone=public --add-port=80/tcp --permanent
	firewall-cmd --reload

	service httpd restart
fi

echo ""; echo ""; echo ""
echo "***I have no idea about your mail environment, so if you want email capability, open up the following***"
echo "nano -w $dir/app/config/production/mail.php"
echo "And edit the attributes appropriately."
sleep 1

echo "";echo "";echo ""
ans=default
until [[ $ans == "yes" ]] || [[ $ans == "no" ]]; do
echo "Q. Shall I delete the password files I created? (Remember to record the passwords before deleting) (y/n)"
read setpw
case $setpw in

      [yY] | [yY][Ee][Ss] )
                rm $createstufffile
				rm $passwordfile
                echo "$createstufffile and $passwordfile files have been removed."
				ans=yes
		;;
        [nN] | [n|N][O|o] )
                echo "Ok, I won't remove the file. Please for the love of security, record the passwords and delete this file regardless."
				echo "$si cannot be held responsible if this file is compromised!"
				echo "From Snipe: I cannot encourage or even facilitate poor security practices, and still sleep the few, frantic hours I sleep at night."
				ans=no
		;;
        *)
		echo "Please select a valid option"
		;;
esac
done

echo ""; echo ""
echo "***If you want mail capabilities, open $dir/app/config/production/mail.php and fill out the attributes***"
echo ""; echo ""
echo "***$si should now be installed. open up http://$fqdn in a web browser to verify.***"
sleep 1
