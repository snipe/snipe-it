###############################################################################
# Snipe IT Install Script for CentOS x64 6.4/6.5
# Should also work on Fedora, Red Hat, openSUSE or any other
# standard APACHE2 and RPM based distros
#
# Created by Cordeos Corp. 2014/08/20
# http://www.cordeos.com  support@cordeos.com
#
#  Important - Your server IP address, hostname should be properly set
#  first BEFORE running this script.
#
#  You will need to edit /etc/sysconfig/network-scripts/ifcfg-Eth0,
#  /etc/hosts and /etc/sysconfig/network files if your IP and Hostname is not set
#
#  REMEMBER /etc/hosts file MUST list FQDN first, hostname second...  
#  i.e. "127.0.0.1   test.domain.com test  localhost.domain.com localhost"
#
###############################################################################

clear

echo "Setting up the environment variables..."
sleep 2s


###############################################################################
# HERE ARE THE SETTINGS YOU CAN CHANGE
# Some should be changed with CAUTION!
###############################################################################

# do not change unless you have a good reason to store elsewhere
export APACHEHOME=/var/www
export SNIPEITNAME=snipeit
export SNIPEITDIR="$APACHEHOME/$SNIPEITNAME"

# do not change - install will break
export SNIPEITDBUSER=travis

# Change this if you want to pull a different fork/branch of application code
export SNIPEITGITFORK=/cordeos/snipe-it
export SNIPEITGITBRANCH=develop

# DEFINITELY CHANGE THESE PASSWORDS!!!
export MYSQLROOTPW=MyPassw0rd
export SNIPEITDBPW=MyPassw0rd

# Leave as is to get your currently set hostname and localhost, or change to custom DNS host
export SERVERNAME=$(hostname -s)
export DOMAINNAME=$(hostname -d)
export FULLSERVERNAME=$HOSTNAME


###############################################################################
# END OF SETTINGS 
###############################################################################


echo "Environment variables set, continuing..."
sleep 5s

echo "Running YUM clean and update..."
sleep 2s

yum -y clean all
yum -y update

echo "All system packages updated, continuing..."
sleep 5s

clear

echo "Removing unneccessary packages..."
sleep 2s

yum -y remove tomcat webanalyzer
yum -y remove PyGreSQL.x86_64 MySQL-python.x86_64 bind* httpd-manual.noarch java*
yum -y remove mod_wsgi.x86_64
yum -y remove perl.x86_64
yum -y remove postgresql.x86_64 
yum -y remove qt.x86_64 qt3.x86_64 samba* wireless-tools.x86_64

echo "All unneccessary packages removed, continuing..."
sleep 5s

clear

echo "Setting up IPTABLES firewall rules for HTTP/HTTPS..."
sleep 2s

chkconfig iptables on
service iptables start
iptables -I INPUT 1 -i eth0 -p tcp --dport 80 -m state --state NEW,ESTABLISHED -j ACCEPT
iptables -I INPUT 1 -i eth0 -p tcp --dport 443 -m state --state NEW,ESTABLISHED -j ACCEPT
service iptables save

echo "IPTABLES firewall rules set..."
sleep 5s

#clear

echo "Installing additional setup tools like git, curl, wget..."
sleep 2s

yum -y install wget curl git

echo "Additional setup tools installed, continuing..."
sleep 5s

#clear

echo "Installing MySQL 5.6..."
sleep 2s

cd $HOME
wget http://dev.mysql.com/get/mysql-community-release-el6-5.noarch.rpm
yum -y localinstall mysql-community-release-el6-*.noarch.rpm
yum -y install mysql-community-server
service mysqld start
chkconfig mysqld on


mysql -u root -e "UPDATE mysql.user SET Password = PASSWORD('$MYSQLROOTPW') WHERE User = 'root';create database $SNIPEITNAME;create user 
'$SNIPEITDBUSER'@'localhost' IDENTIFIED BY '$SNIPEITDBPW';grant all privileges on $SNIPEITNAME.* to '$SNIPEITDBUSER'@'localhost';flush privileges;"

echo "MySQL 5.6 installed and configured, continuing..."
sleep 5s

#clear

echo "Setup PHP5.5 and related PHP modules..."
sleep 2s

cd $HOME
wget http://download.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
rpm -ivh epel-release-6-8.noarch.rpm
wget http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
rpm -Uvh remi-release-6*.rpm
yum -y --enablerepo=remi update

chkconfig httpd on
service httpd start

yum -y --enablerepo=remi install php php-xml php-mcrypt php-pdo php-mysqlnd php-gd

echo "PHP5.5 and modules installed, continuing..."
sleep 5s

#clear

echo "Creating and cloning the SNIPE-IT application from GITHUB..."
sleep 2s

mkdir $SNIPEITDIR
cd $SNIPEITDIR
git clone -b $SNIPEITGITBRANCH https://github.com/$SNIPEITGITFORK $SNIPEITDIR

echo "SNIPE-IT application copied to local server from GITHUB, continuing..."
sleep 5s

#clear

echo "Creating the APACHE configuration file for Snipe IT..."
sleep 2s

echo "#*****************************************************************" >> /etc/httpd/conf.d/snipeit.conf
echo "# SNIPEIT APACHE SITE CONFIG" >> /etc/httpd/conf.d/snipeit.conf
echo "# http://www.cordeos.com    support@cordeos.com" >> /etc/httpd/conf.d/snipeit.conf
echo "#" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "# Listen for virtual host requests on all IP addresses" >> /etc/httpd/conf.d/snipeit.conf
echo "NameVirtualHost *:80" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "<VirtualHost *:80>" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "# This directory parameter is needed for mod_rewrite to work properly" >> /etc/httpd/conf.d/snipeit.conf
echo "<Directory $SNIPEITDIR/public>" >> /etc/httpd/conf.d/snipeit.conf
echo "	AllowOverride All" >> /etc/httpd/conf.d/snipeit.conf
echo "</Directory>" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "# Your application-public root folder" >> /etc/httpd/conf.d/snipeit.conf
echo "DocumentRoot $SNIPEITDIR/public" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "ServerName "$FULLSERVERNAME >> /etc/httpd/conf.d/snipeit.conf
echo "ServerAlias "$SERVERNAME >> /etc/httpd/conf.d/snipeit.conf
echo "#if using a simply/common server short name as well..." >> /etc/httpd/conf.d/snipeit.conf
echo "ServerAlias localhost" >> /etc/httpd/conf.d/snipeit.conf
echo "ServerAlias localhost.$DOMAINNAME" >> /etc/httpd/conf.d/snipeit.conf
echo "ServerAlias $SNIPEITNAME.$DOMAINNAME" >> /etc/httpd/conf.d/snipeit.conf
echo "ServerAlias $SNIPEITNAME" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "# Other directives here" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "</VirtualHost>" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf
echo "#*****************************************************************" >> /etc/httpd/conf.d/snipeit.conf
echo "" >> /etc/httpd/conf.d/snipeit.conf

echo "Apache configuration file created, continuing..."
sleep 5s

#clear

echo "Editing Snipe IT configuration files..."
sleep 2s

cp $SNIPEITDIR/app/config/production/database.example.php $SNIPEITDIR/app/config/production/database.php
cp $SNIPEITDIR/app/config/production/mail.example.php $SNIPEITDIR/app/config/production/mail.php
cp $SNIPEITDIR/app/config/production/app.example.php $SNIPEITDIR/app/config/production/app.php

sed -i "s/staging.yourserver.com/$FULLSERVERNAME/g" $SNIPEITDIR/app/config/production/app.php
sed -i "s/\x27debug\x27 => true/\x27debug\x27 => false/g" $SNIPEITDIR/app/config/production/app.php
sed -i "s/\x27database\x27  => \x27snipeit_laravel\x27/\x27database\x27  => \x27$SNIPEITNAME\x27/g" $SNIPEITDIR/app/config/production/database.php
sed -i "s/\x27username\x27  => \x27travis\x27/\x27username\x27  => \x27$SNIPEITDBUSER\x27/g" $SNIPEITDIR/app/config/production/database.php
sed -i "s/\x27password\x27  => \x27\x27/\x27password\x27  => \x27$SNIPEITDBPW\x27/g" $SNIPEITDIR/app/config/production/database.php

echo "Snipe IT configuration files set, continuing..."
sleep 5s

#clear 

echo "Installing and updating Laravel Framework..."
sleep 2s

cd $SNIPEITDIR
curl -sS https://getcomposer.org/installer | php
php composer.phar install
php composer.phar update
php composer.phar dump-autoload
php artisan clear-compiled

chgrp -R apache $SNIPEITDIR
chmod -R 754 $SNIPEITDIR
chmod -R 774 $SNIPEITDIR/app/storage/


#cd $SNIPEITDIR
php artisan key:generate --env=production

service httpd restart

echo "Laravel installed, configured and updated, continuing..."
sleep 5s

#clear

echo "Begin basic software install/setup..."
sleep 2s
echo "Snipe INSTALLATION complete.  Please change to the install directory (cd $SNIPEITDIR) and run [php artisan app:install] to setup the application."

cd $SNIPEITDIR
php artisan app:install

