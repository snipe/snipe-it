###############################################################################
# Snipe IT Install Script for CentOS x64 7.0
# Should also work on Fedora, Red Hat, openSUSE or any other
# standard APACHE2 and RPM based distros
#
# Created by Cordeos Corp. 2014/09/08
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


###############################################################################
# HERE ARE THE SETTINGS YOU CAN CHANGE
# Some should be changed with CAUTION!
###############################################################################

MYSQLREPO='http://dev.mysql.com/get/'
MYSQLRPM='mysql-community-release-el6-5.noarch.rpm'
EPELREPO='http://dl.fedoraproject.org/pub/epel/beta/7/x86_64/'
EPELRPM='epel-release-7-1.noarch.rpm'
REMIREPO='http://rpms.famillecollet.com/enterprise/'
REMIRPM='remi-release-7.rpm'
LOG_FILE='snipeit_install_log.txt'


#exec > >(tee -a ${LOG_FILE} )
#exec 2> >(tee -a ${LOG_FILE} >&2)


clear

echo ''
echo 'Snipe IT Automated Install Script: 7.0-3.21'
echo ''
echo "This will install Snipe IT Asset Management for CentOS 7.0..."
echo "Are you sure your server is CentOS 7? Do you want to continue?"
select yn in "Yes" "No"; do
    case $yn in
        Yes ) break;;
        No ) exit;;
    esac
done

echo ''
echo ''

echo "Setting up the environment variables..."
sleep 2s

# do not change unless you have a good reason to store elsewhere
APACHEHOME=/var/www
read -e -i "$APACHEHOME" -p "Confirm your Apache root directory: " input
APACHEHOME="${input:-$APACHEHOME}"

SNIPEITNAME=snipeit
read -e -i "$SNIPEITNAME" -p "Confirm Snipe IT database/site name (no special chars!): " input
SNIPEITNAME="${input:-$SNIPEITNAME}"

SNIPEITDIR="$APACHEHOME/$SNIPEITNAME"
read -e -i "$SNIPEITDIR" -p "Confirm your Snipe IT install directory: " input
SNIPEITDIR="${input:-$SNIPEITDIR}"

# do not change - install will break
SNIPEITDBUSER=snipeit
read -e -i "$SNIPEITDBUSER" -p "Confirm your Snipe IT database user: " input
SNIPEITDBUSER="${input:-$SNIPEITDBUSER}"

# Change this if you want to pull a different fork/branch of application code
SNIPEITGITFORK=/cordeos/snipe-it
read -e -i "$SNIPEITGITFORK" -p "Confirm your Snipe IT code fork to pull: " input
SNIPEITGITFORK="${input:-$SNIPEITGITFORK}"

SNIPEITGITBRANCH=beta1
read -e -i "$SNIPEITGITBRANCH" -p "Confirm Snipe IT code branch to pull: " input
SNIPEITGITBRANCH="${input:-$SNIPEITGITBRANCH}"

# DEFINITELY CHANGE THESE PASSWORDS!!!
MYSQLROOTPW=''
MYSQLNEW=''

echo ''

echo "Is MySQL already configured with a ROOT password (select 'NO' if this is a fresh server installation)?"
select yn in "Yes" "No"; do
    case $yn in
        Yes)    MYSQLNEW='No'
                while true; do
                    read -e -i "$MYSQLROOTPW" -p "Please enter your current MySQL root password (REQUIRED): " input
                    MYSQLROOTPW="${input:-$MYSQLROOTPW}"
                    LEN=$(echo ${#MYSQLROOTPW})
                    # echo $LEN
                    if [ $LEN -lt 6 ] 
                    then
                        echo "Password must be at least 6 characters"
                    else
                        break
                    fi
                done

                break;;

        No)     MYSQLNEW='Yes'
                while true; do
                    read -e -i "$MYSQLROOTPW" -p "Please enter a new MySQL root password (REQUIRED): " input
                    MYSQLROOTPW="${input:-$MYSQLROOTPW}"
                    LEN=$(echo ${#MYSQLROOTPW})
                    # echo $LEN
                    if [ $LEN -lt 6 ] 
                    then
                        echo "Password must be at least 6 characters"
                    else
                        break
                    fi
                done

                break;;
    esac
done

echo ''


SNIPEITDBPW=''
while true; do
    read -e -i "$SNIPEITDBPW" -p "Please enter a new Snipe IT database password (REQUIRED): " input
    SNIPEITDBPW="${input:-$SNIPEITDBPW}"
    LEN=$(echo ${#SNIPEITDBPW})
    # echo $LEN
    if [ $LEN -lt 6 ]
    then
        echo "Password must be at least 6 characters"
    else
        break
    fi
done

echo ''

# Leave as is to get your currently set hostname and localhost, or change to custom DNS host
SERVERNAME=$(hostname -s)
read -e -i "$SERVERNAME" -p "Confirm your server host name: " input
SERVERNAME="${input:-$SERVERNAME}"

DOMAINNAME=$(hostname -d)
read -e -i "$DOMAINNAME" -p "Confirm your domain name: " input
DOMAINNAME="${input:-$DOMAINNAME}"

FULLSERVERNAME=$HOSTNAME
read -e -i "$FULLSERVERNAME" -p "Confirm your full server network name: " input
FULLSERVERNAME="${input:-$FULLSERVERNAME}"

clear

echo ''
echo "Please confirm your settings are correct:"
echo ''
echo "Apache home directory: $APACHEHOME"
echo "Snipe IT site name: $SNIPEITNAME"
echo "Snipe IT install directory: $SNIPEITDIR"
echo "Snipe IT code fork: $SNIPEITGITFORK"
echo "Snipe IT code branch: $SNIPEITGITBRANCH"
echo "New MYSQL Installation: $MYSQLNEW"
echo "MySQL root password: $MYSQLROOTPW"
echo "Snipe IT database user: $SNIPEITDBUSER"
echo "Snipe IT database password: $SNIPEITDBPW"
echo "Server host name: $SERVERNAME"
echo "Domain name: $DOMAINNAME"
echo "Site URL: $FULLSERVERNAME"
echo ''

echo "Do you wish to install Snipe IT with these settings?"
select yn in "Yes" "No"; do
    case $yn in
        Yes ) break;;
        No ) exit;;
    esac
done

clear
echo ''
echo "Install settings saved, continuing..."
echo ''
sleep 5s

###############################################################################
# END OF SETTINGS 
###############################################################################


echo "Running YUM clean and update..."
sleep 2s

yum -y clean all
yum -y update

echo "All system packages updated, continuing..."
sleep 5s

clear

echo "Removing unneccessary packages..."
sleep 2s

yum -y remove httpd-manual

echo "All unneccessary packages removed, continuing..."
sleep 5s

clear

echo "Setting up IPTABLES firewall rules for HTTP/HTTPS..."
sleep 2s

# CONFIGURE THE IPTABLES FIREWALL RULES
# CENTOS 7 now uses firewalld instead of iptables.  
# You can revert to iptables by installing and configuring the iptables-services package (NOT RECOMMENDED)

chkconfig firewalld on
service firewalld start
firewall-cmd --zone=public --add-port=http/tcp
firewall-cmd --zone=public --add-port=http/tcp --permanent
firewall-cmd --zone=public --add-port=https/tcp
firewall-cmd --zone=public --add-port=https/tcp --permanent
firewall-cmd --reload

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
rm -f $MYSQLRPM

echo "Downloading MYSQL install files... $MYSQLREPO$MYSQLRPM"
echo ''
wget $MYSQLREPO$MYSQLRPM

if [ $? -ne 0 ]; then
    echo 'MySQL RPM download failed, will try again...'
    sleep 10
    wget $MYSQLREPO$MYSQLRPM

        if [ $? -ne 0 ]; then
            echo 'MySQL RPM download failed, will try again...'
            sleep 10
            wget $MYSQLREPO$MYSQLRPM
            
            if [ $? -ne 0 ]; then
                echo 'MySQL RPM download failed, script aborted.'
                exit
            fi
        fi
fi

    echo 'MySQL RPM download successful.'
    yum -y localinstall $MYSQLRPM
    yum -y install mysql-community-server
    service mysqld start
    chkconfig mysqld on

if [ "$MYSQLNEW" == 'Yes' ] 
    then
        mysql -u root -e "UPDATE mysql.user SET Password = PASSWORD('$MYSQLROOTPW') WHERE User = 'root';create database $SNIPEITNAME;create user '$SNIPEITDBUSER'@'localhost' IDENTIFIED BY '$SNIPEITDBPW';grant all privileges on $SNIPEITNAME.* to '$SNIPEITDBUSER'@'localhost';flush privileges;"
    else
        mysql -u root -p$MYSQLROOTPW -e "create database $SNIPEITNAME;create user '$SNIPEITDBUSER'@'localhost' IDENTIFIED BY '$SNIPEITDBPW';grant all privileges on $SNIPEITNAME.* to '$SNIPEITDBUSER'@'localhost';flush privileges;"
    fi

if [ $? -ne 0 ]; then
    echo 'MySQL database or user create failed, script aborted.'
    exit
fi

echo "MySQL 5.6 installed and configured, continuing..."

sleep 5s

#clear

echo "Setup PHP5.5 and related PHP modules..."
sleep 2s

# INSTALL PHP 5..5 AND A FEW OTHER NEEDED PHP ELEMENTS
# These packages and repositories are specific to 
# RHEL/CentOS 7 64-Bit - do not mistakenly use the 6.4 or 6.5 ones!

cd $HOME
rm -f $EPELRPM
rm -f $REMIRPM

echo "Downloading EPEL Repository files... $EPELREPO$EPELRPM"
echo ''

wget $EPELREPO$EPELRPM

if [ $? -ne 0 ]; then
    echo 'EPEL RPM download failed, will try again...'
    sleep 10

    wget $EPELREPO$EPELRPM

        if [ $? -ne 0 ]; then
            echo 'EPEL RPM download failed, will try again...'
            sleep 10

            wget $EPELREPO$EPELRPM
            
            if [ $? -ne 0 ]; then
                echo 'EPEL RPM download failed, script aborted.'
                exit
            fi
        fi
    fi

    echo 'EPEL RPM download successful.'
    rpm -Uvh $EPELRPM 

sleep 10

echo "Downloading REMI Repository files... $REMIREPO$REMIRPM"
echo ''

wget $REMIREPO$REMIRPM

if [ $? -ne 0 ]; then
    echo 'REMI RPM download failed, will try again...'
    sleep 10

    wget $REMIREPO$REMIRPM

        if [ $? -ne 0 ]; then
            echo 'REMI RPM download failed, will try again...'
            sleep 10

            wget $REMIREPO$REMIRPM
            
            if [ $? -ne 0 ]; then
                echo 'REMI RPM download failed, script aborted.'
                exit
            fi
        fi
fi

    echo 'REMI RPM download successful.'
    rpm -Uvh $REMIRPM

yum -y --enablerepo=remi update

chkconfig httpd on
service httpd start

yum -y --enablerepo=remi,remi-php55 install php php-xml php-mcrypt php-pdo php-mysqlnd php-gd

# ENABLE HTTP PERMISSION CHANGE TO SELINUX SECURITY - NEW FOR CENTOS 7.0
setsebool -P httpd_unified 1

# DISABLE ANY ADDITIONAL APACHE CONFIG LOADERS
# To reduce conflicts, eliminate uneccessary modules and reduce security exposure, 
# rename any unneeded Apache conf files

mv -f autoindex.conf autoindex.bak
mv -f fcgid.conf fcgid.bak
mv -f userdir.conf userdir.bak
mv -f welcome.conf welcome.bak

echo "PHP5.5 and modules installed, continuing..."
sleep 5s

#clear

echo "Creating and cloning the SNIPE-IT application from GITHUB..."
sleep 2s

cp -rfau $SNIPEITDIR $SNIPEITDIR_BAK
rm -rf $SNIPEITDIR
mkdir $SNIPEITDIR
cd $SNIPEITDIR
git clone -b $SNIPEITGITBRANCH https://github.com/$SNIPEITGITFORK $SNIPEITDIR

echo "SNIPE-IT application copied to local server from GITHUB, continuing..."
sleep 5s

#clear

echo "Creating the APACHE configuration file for Snipe IT..."
sleep 2s
cp -ua /etc/httpd/conf.d/$SNIPEITNAME.conf /etc/httpd/conf.d/$SNIPEITNAME.conf.bak
rm -f /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "#*****************************************************************" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# SNIPEIT APACHE SITE CONFIG" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# http://www.cordeos.com    support@cordeos.com" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "#" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# Listen for virtual host requests on all IP addresses" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "NameVirtualHost *:80" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "<VirtualHost *:80>" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# This directory parameter is needed for mod_rewrite to work properly" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "<Directory $SNIPEITDIR/public>" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "	AllowOverride All" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "</Directory>" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# Your application-public root folder" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "DocumentRoot $SNIPEITDIR/public" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerName "$FULLSERVERNAME >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerAlias "$SERVERNAME >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "#if using a simply/common server short name as well..." >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerAlias localhost" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerAlias localhost.$DOMAINNAME" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerAlias $SNIPEITNAME.$DOMAINNAME" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "ServerAlias $SNIPEITNAME" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "# Other directives here" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "</VirtualHost>" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "#*****************************************************************" >> /etc/httpd/conf.d/$SNIPEITNAME.conf
echo "" >> /etc/httpd/conf.d/$SNIPEITNAME.conf

echo "Apache configuration file created, continuing..."
sleep 5s

#clear

echo "Creating the GITHUB update script file for Snipe IT..."
sleep 2s
rm -f $HOME/snipeit-git-update.sh
echo "#*****************************************************************" >> $HOME/snipeit-git-update.sh
echo "# SNIPEIT GITHUB UPDATE SCRIPT" >> $HOME/snipeit-git-update.sh
echo "# http://www.cordeos.com    support@cordeos.com" >> $HOME/snipeit-git-update.sh
echo "#" >> $HOME/snipeit-git-update.sh
echo "" >> $HOME/snipeit-git-update.sh
echo "cd $SNIPEITDIR" >> $HOME/snipeit-git-update.sh
echo "git remote rm cordeos" >> $HOME/snipeit-git-update.sh
echo "git remote add cordeos git://github.com$SNIPEITGITFORK.git" >> $HOME/snipeit-git-update.sh
echo "git remote rm master" >> $HOME/snipeit-git-update.sh
echo "git remote add master git://github.com/snipe/snipe-it.git" >> $HOME/snipeit-git-update.sh
echo "git fetch cordeos" >> $HOME/snipeit-git-update.sh
echo "git reset --hard cordeos/$SNIPEITGITBRANCH" >> $HOME/snipeit-git-update.sh
echo "php composer.phar self-update" >> $HOME/snipeit-git-update.sh
echo "php composer.phar update" >> $HOME/snipeit-git-update.sh
echo "php composer.phar dump-autoload" >> $HOME/snipeit-git-update.sh
echo "php artisan clear-compiled" >> $HOME/snipeit-git-update.sh
echo "php artisan migrate" >> $HOME/snipeit-git-update.sh
echo "#*****************************************************************" >> $HOME/snipeit-git-update.sh
echo "" >> $HOME/snipeit-git-update.sh

chmod 774 $HOME/snipeit-git-update.sh

echo "GITHUB update file created, continuing..."
sleep 5s

#clear

echo "Creating the Snipe IT backup script..."
sleep 2s
rm -f $HOME/snipeit-backup.sh
echo "#*****************************************************************" >> $HOME/snipeit-backup.sh
echo "# SNIPEIT BACKUP SCRIPT" >> $HOME/snipeit-backup.sh
echo "# http://www.cordeos.com    support@cordeos.com" >> $HOME/snipeit-backup.sh
echo "#" >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'DATE=`date +%d-%b-%Y-%I:%M:%S%p`' >> $HOME/snipeit-backup.sh
echo 'mkdir -p $HOME/SNIPEITBACKUP/$DATE' >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Starting backup for $HOSTNAME...'\" >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Backing up $HOSTNAME /etc...'\" >> $HOME/snipeit-backup.sh
echo 'tar -czPf $HOME/SNIPEITBACKUP/$DATE/$HOSTNAME-etc.tar.gz /etc' >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Backing up $HOSTNAME /var/log...'\" >> $HOME/snipeit-backup.sh
echo 'tar -czPf $HOME/SNIPEITBACKUP/$DATE/$HOSTNAME-log.tar.gz /var/log' >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Backing up $HOSTNAME /var/www...'\" >> $HOME/snipeit-backup.sh
echo 'tar -czPf $HOME/SNIPEITBACKUP/$DATE/$HOSTNAME-www.tar.gz /var/www' >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Dumping $HOSTNAME MySQL databases files...'\" >> $HOME/snipeit-backup.sh
echo "mysqldump -u root -p$MYSQLROOTPW --all-databases > /var/lib/mysql/alldatabases.sql" >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Backing up $HOSTNAME MySQL configuration files...'\" >> $HOME/snipeit-backup.sh
echo 'tar -czPf $HOME/SNIPEITBACKUP/$DATE/$HOSTNAME-mysql.tar.gz /var/lib/mysql/alldatabases.sql' >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo 'echo '\"'Done.'\" >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh
echo "#*****************************************************************" >> $HOME/snipeit-backup.sh
echo "" >> $HOME/snipeit-backup.sh

chmod 774 $HOME/snipeit-backup.sh

echo "Snipe IT backup script file created, continuing..."
sleep 5s

#clear

echo "Editing Snipe IT configuration files..."
sleep 2s

cp -au $SNIPEITDIR/app/config/production/database.php $SNIPEITDIR/app/config/production/database.php.bak
rm -f $SNIPEITDIR/app/config/production/database.php
cp -au $SNIPEITDIR/app/config/production/mail.php $SNIPEITDIR/app/config/production/mail.php.bak
rm -f $SNIPEITDIR/app/config/production/mail.php
cp -au $SNIPEITDIR/app/config/production/app.php $SNIPEITDIR/app/config/production/app.php.bak
rm -f $SNIPEITDIR/app/config/production/app.php

cp -au $SNIPEITDIR/app/config/production/database.example.php $SNIPEITDIR/app/config/production/database.php
cp -au $SNIPEITDIR/app/config/production/mail.example.php $SNIPEITDIR/app/config/production/mail.php
cp -au $SNIPEITDIR/app/config/production/app.example.php $SNIPEITDIR/app/config/production/app.php

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
rm -f composer.phar
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

clear

###############################################################################
# END OF BASIC SETUP 
###############################################################################

echo "The basic system setup is complete.  Do you want to setup Snipe IT now?"
echo ''
echo "If you choose not to setup Snipe IT now, the application will not"
echo "function until you complete this final step.  To proceed with setup"
echo "later please change to the Snipe IT install directory (cd $SNIPEITDIR)"
echo "then run [php artisan app:install] to setup the application."
echo ''
echo "Proceed with final setup?"
echo ''
select yn in "Yes" "No"; do
    case $yn in
        Yes ) break;;
        No ) exit;;
    esac
done

clear


###############################################################################
# APP INSTALL 
###############################################################################

cd $SNIPEITDIR
php artisan app:install



