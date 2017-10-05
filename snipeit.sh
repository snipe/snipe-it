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
hostname="$(hostname)"
fqdn="$(hostname --fqdn)"
ans=default
hosts=/etc/hosts
tmp=/tmp/$name

spin[0]="-"
spin[1]="\\"
spin[2]="|"
spin[3]="/"

rm -rf ${tmp:?}
mkdir $tmp

# Debian/Ubuntu friendly f(x)s
progress () {
    while kill -0 $pid > /dev/null 2>&1
        do
            for i in "${spin[@]}"
                do
                        echo -ne "\b$i"
                        sleep .1
                done
        done
}


#Used for Debian and Ubuntu
vhenvfile () {
    find /etc/apache2/mods-enabled -maxdepth 1 -name 'rewrite.load' >/dev/null 2>&1
    apachefile=/etc/apache2/sites-available/$name.conf
    echo "* Creating Virtual host for apache."
    {
        echo "<VirtualHost *:80>"
        echo "ServerAdmin webmaster@localhost"
        echo "<Directory $webdir/$name/public>"
        echo "        Require all granted"
        echo "        AllowOverride All"
        echo "   </Directory>"
        echo "    DocumentRoot $webdir/$name/public"
        echo "    ServerName $fqdn"
        echo "        ErrorLog /var/log/apache2/snipeIT.error.log"
        echo "        CustomLog /var/log/apache2/access.log combined"
        echo "</VirtualHost>"
    } >> $apachefile
    echo >> $hosts "127.0.0.1 $hostname $fqdn"
    log "a2ensite $name.conf"
}

perms () {
    chmod_dirs=( "$webdir/$name/storage" )
    chmod_dirs+=( "$webdir/$name/storage/private_uploads" )
    chmod_dirs+=( "$webdir/$name/public/uploads" )
    #Change permissions on directories
    for chmod_dir in "${chmod_dirs[@]}"
    do
        chmod -R 755 "$chmod_dir"
    done
}

log () {
    eval "$@" |& tee -a /var/log/snipeit-install.log >/dev/null 2>&1
}

setenv () {
    cp $webdir/$name/.env.example $webdir/$name/.env

    sed -i '1 i\#Created By Snipe-it Installer' $webdir/$name/.env
    sed -i 's,^\(APP_TIMEZONE=\).*,\1'$tzone',' $webdir/$name/.env
    sed -i 's,^\(DB_HOST=\).*,\1'localhost',' $webdir/$name/.env
    sed -i 's,^\(DB_DATABASE=\).*,\1'snipeit',' $webdir/$name/.env
    sed -i 's,^\(DB_USERNAME=\).*,\1'snipeit',' $webdir/$name/.env
    sed -i 's,^\(DB_PASSWORD=\).*,\1'$mysqluserpw',' $webdir/$name/.env
    sed -i 's,^\(APP_URL=\).*,\1'http://$fqdn',' $webdir/$name/.env
}

#CentOS Friendly f(x)s
function isinstalled {
    if yum list installed "$@" >/dev/null 2>&1; then
        true
    else
        false
    fi
}

if [ -f /etc/lsb-release ]; then
    distro="$(lsb_release -s -i )"
    version="$(lsb_release -s -r)"
    codename="$(lsb_release -c -s)"
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
echo "  Welcome to Snipe-IT Inventory Installer for Centos, Debian and Ubuntu!"
echo ""
shopt -s nocasematch
case $distro in
    *Ubuntu*)
        echo "  The installer has detected Ubuntu version $version as the OS."
        distro=ubuntu
        ;;
    *Debian*)
        echo "  The installer has detected Debian version $version as the OS."
        distro=debian
        ;;
    *centos*|*redhat*|*ol*|*rhel*)
        echo "  The installer has detected $distro version $version as the OS."
        distro=centos
        ;;
    *)
        echo "  The installer was unable to determine your OS. Exiting for safety."
        exit
        ;;
esac
shopt -u nocasematch
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
echo -n "  Q. Do you want to automatically create the database user password? (y/n) "
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
    *)  echo "  Invalid answer. Please type y or n"
        ;;
esac
done

## TODO: Progress tracker on each step

case $distro in
    debian)
        #####################################  Install for Debian ##############################################
        #Update/upgrade Debian/Ubuntu repositories, get the latest version of git.
        #Git clone snipeit, create vhost, edit hosts file, create .env file, mysql install
        #composer install, set permissions, restart apache.
        #BTW, Debian, I swear, you're such a pain.

        webdir=/var/www
        echo -e "\n* Updating Debian packages in the background... ${spin[0]}\n"
        apt-get update >> /var/log/snipeit-install.log & pid=$! 2>&1
        wait
        apt-get upgrade >> /var/log/snipeit-install.log & pid=$! 2>&1
        wait
        echo -e "\n* Installing packages... ${spin[0]}\n"
        echo -e "\n* Going to suppress more messages that you don't need to worry about. Please wait... ${spin[0]}"
        DEBIAN_FRONTEND=noninteractive apt-get -y install mariadb-server mariadb-client apache2 git unzip php5 php5-mcrypt php5-curl php5-mysql php5-gd php5-ldap libapache2-mod-php5 curl >> /var/log/snipeit-install.log & pid=$! 2>&1
        progress
        wait
        echo -e "\n* Cloning Snipeit, extracting to $webdir/$name..."
        git clone https://github.com/snipe/snipe-it $webdir/$name >> /var/log/snipeit-install.log & pid=$! 2>&1
        progress
        php5enmod mcrypt >> /var/log/snipeit-install.log 2>&1
        a2enmod rewrite >> /var/log/snipeit-install.log 2>&1
        tzone=$(cat /etc/timezone)
        setenv
        vhenvfile
        wait
        echo >> $hosts "127.0.0.1 $hostname $fqdn"
        a2ensite $name.conf
        echo -e "* Modify the Snipe-It files necessary for a production environment.\n* Securing Mysql"
        # Have user set own root password when securing install
        # and just set the snipeit database user at the beginning
        /usr/bin/mysql_secure_installation
        echo -e "* Creating Mysql Database and User.\n##  Please Input your MySQL/MariaDB root password: "
        mysql -u root -p --execute="CREATE DATABASE snipeit;GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"
        cd $webdir/$name/
        curl -sS https://getcomposer.org/installer | php
        php composer.phar install --no-dev --prefer-source
        perms
        service apache2 restart
        php artisan key:generate
        ;;
    ubuntu)
    if [[ "$version" =~ 1[6-7] ]]; then
        #####################################  Install for Ubuntu 16+  ##############################################
        webdir=/var/www

        echo "* Adding MariaDB repository."
        log "apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8"
        log "add-apt-repository 'deb [arch=amd64,i386] http://nyc2.mirrors.digitalocean.com/mariadb/repo/10.1/ubuntu $codename main'"

        echo "* Updating with apt-get update."
        log "apt-get update" & pid=$!
        [ -f /var/lib/dpkg/lock ] && rm -f /var/lib/dpkg/lock
        progress

        echo "* Upgrading packages with apt-get upgrade."
        log "apt-get -y upgrade" & pid=$!
        progress

        echo "* Installing httpd, PHP, MariaDB and other requirements."
        log "DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server mariadb-client apache2 libapache2-mod-php php php-mcrypt php-curl php-mysql php-gd php-ldap php-zip php-mbstring php-xml php-bcmath curl git unzip" & pid=$!
        progress

        log "phpenmod mcrypt"
        log "phpenmod mbstring"
        log "a2enmod rewrite"

        echo "* Cloning Snipe-IT from github to the web directory."
        log "git clone https://github.com/snipe/snipe-it $webdir/$name" & pid=$!
        progress
        
        echo "* Configuring .env file."
        tzone=$(cat /etc/timezone)
        setenv
        
        vhenvfile
        
        echo "* Starting the MariaDB server.";       
        service mysql status >/dev/null || service mysql start
        
        echo "* Securing MariaDB server.";
        /usr/bin/mysql_secure_installation
    
        echo "* Creating MariaDB Database/User."
        echo "* Please Input your MariaDB root password:"
        mysql -u root -p --execute="CREATE DATABASE snipeit;GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"

        echo "* Installing and running composer."
        cd $webdir/$name/
        curl -sS https://getcomposer.org/installer  | php
        php composer.phar install --no-dev --prefer-source
        
        perms
        chown -R www-data:www-data "/var/www/$name"
        
        service apache2 restart

        echo "* Generating the application key."
        php artisan key:generate --force

        echo "* Artisan Migrate."
        php artisan migrate --force
    
    elif [[ "$version" =~ 14 ]]; then
        #####################################  Install for Ubuntu 14  ##############################################
        webdir=/var/www

        echo "* Adding MariaDB and ppa:ondrej/php repositories."
        log "apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db"
        log "add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://nyc2.mirrors.digitalocean.com/mariadb/repo/10.1/ubuntu $codename main'"
        #PHP7 repository
        log "add-apt-repository ppa:ondrej/php -y"

        echo "* Updating with apt-get update."
        log "apt-get update" & pid=$!
        [ -f /var/lib/dpkg/lock ] && rm -f /var/lib/dpkg/lock
        progress

        echo "* Upgrading packages with apt-get upgrade."
        log "apt-get -y upgrade" & pid=$!
        progress

        echo "* Installing httpd, PHP, MariaDB and other requirements."
        log "DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server mariadb-client php7.1 php7.1-mcrypt php7.1-curl php7.1-mysql php7.1-gd php7.1-ldap php7.1-zip php7.1-mbstring php7.1-xml php7.1-bcmath curl git unzip" & pid=$!
        progress

        log "phpenmod mcrypt"
        log "phpenmod mbstring"
        log "a2enmod rewrite"

        echo "* Cloning Snipe-IT from github to the web directory."
        log "git clone https://github.com/snipe/snipe-it $webdir/$name" & pid=$!
        progress
        
        echo "* Configuring .env file."
        tzone=$(cat /etc/timezone)
        setenv
        
        vhenvfile
        
        echo "* Starting the MariaDB server.";       
        service mysql status >/dev/null || service mysql start
        
        echo "* Securing MariaDB server.";
        /usr/bin/mysql_secure_installation
    
        echo "* Creating MariaDB Database/User."
        echo "* Please Input your MariaDB root password:"
        mysql -u root -p --execute="CREATE DATABASE snipeit;GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"

        echo "* Installing and running composer."
        cd $webdir/$name/
        curl -sS https://getcomposer.org/installer  | php
        php composer.phar install --no-dev --prefer-source
        
        perms
        chown -R www-data:www-data "/var/www/$name"
        
        service apache2 restart

        echo "* Generating the application key."
        php artisan key:generate --force

        echo "* Artisan Migrate."
        php artisan migrate --force

    else
        echo "Unable to Handle Ubuntu Version #.  Version Found: " $version
    return 1
    fi
    ;;
    centos)
    if [[ "$version" =~ ^6 ]]; then
        #####################################  Install for Centos/Redhat 6  ##############################################

        webdir=/var/www/html
        #Allow us to get the mysql engine
        echo ""
        echo "##  Adding IUS, epel-release and MariaDB repositories.";
        mariadbRepo=/etc/yum.repos.d/MariaDB.repo
        touch "$mariadbRepo"
        {
            echo "[mariadb]"
            echo "name = MariaDB"
            echo "baseurl = http://yum.mariadb.org/10.0/centos6-amd64"
            echo "gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB"
            echo "gpgcheck=1"
            echo "enable=1"
        } >> "$mariadbRepo"

        log "yum -y install wget epel-release"
        log "yum -y install https://centos6.iuscommunity.org/ius-release.rpm"
        log "rpm --import /etc/pki/rpm-gpg/IUS-COMMUNITY-GPG-KEY"

        #Install PHP and other needed stuff
        echo "##  Installing httpd, PHP, MariaDB and other requirements.";
        PACKAGES="httpd mariadb-server git unzip php71u php71u-mysqlnd php71u-bcmath php71u-cli php71u-common php71u-embedded php71u-gd php71u-mbstring php71u-mcrypt php71u-ldap php71u-json php71u-simplexml"

        for p in $PACKAGES;do
            if isinstalled "$p"; then
                echo " ## $p already installed"
            else
                echo -n " ## Installing $p ... "
                log "yum -y install $p"
                echo "";
            fi
        done;

        echo -e "\n##  Cloning Snipe-IT from github to the web directory.";

        log "git clone https://github.com/snipe/snipe-it $webdir/$name"

        # Make mariaDB start on boot and restart the daemon
        echo "##  Starting the MariaDB server.";
        chkconfig mysql on
        /sbin/service mysql start

        echo "##  Securing MariaDB server.";
        /usr/bin/mysql_secure_installation

        echo "##  Creating MariaDB Database/User."
        echo "##  Please Input your MariaDB root password: "
        mysql -u root -p --execute="CREATE DATABASE snipeit;GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"

        #Create the new virtual host in Apache and enable rewrite
        echo "##  Creating the new virtual host in Apache.";
        apachefile=/etc/httpd/conf.d/$name.conf

        {
            echo ""
            echo ""
            echo ""
            echo "<VirtualHost *:80>"
            echo "ServerAdmin webmaster@localhost"
            echo "    <Directory $webdir/$name/public>"
            echo "        Allow From All"
            echo "        AllowOverride All"
            echo "        Options +Indexes"
            echo "   </Directory>"
            echo "    DocumentRoot $webdir/$name/public"
            echo "    ServerName $fqdn"
            echo "        ErrorLog /var/log/httpd/snipeIT.error.log"
            echo "        CustomLog /var/log/access.log combined"
            echo "</VirtualHost>"
        } >> "$apachefile"

        echo "##  Setting up hosts file.";
        echo >> $hosts "127.0.0.1 $hostname $fqdn"

        # Make apache start on boot and restart the daemon
        echo "##  Starting the apache server.";
        chkconfig httpd on
        /sbin/service httpd start
        
        echo "##  Configuring .env file."
        tzone=$(grep ZONE /etc/sysconfig/clock | tr -d '"' | sed 's/ZONE=//g');
        setenv

        echo "##  Installing and running composer."
        cd $webdir/$name
        curl -sS https://getcomposer.org/installer | php
        php composer.phar install --no-dev --prefer-source

        perms
        chown -R apache:apache $webdir/$name

        /sbin/service iptables status >/dev/null 2>&1
        if [ $? = 0 ]; then
            #Open http/https port
            iptables -I INPUT 1 -p tcp -m tcp --dport 80 -j ACCEPT
            iptables -I INPUT 1 -p tcp -m tcp --dport 443 -j ACCEPT
            #Save iptables
            service iptables save
        fi

        service httpd restart
        
        echo "##  Generating the application key."
        php artisan key:generate --force

        echo "##  Artisan Migrate."
        php artisan migrate --force

    elif [[ "$version" =~ ^7 ]]; then
        #####################################  Install for Centos/Redhat 7  ##############################################

        webdir=/var/www/html

        #Allow us to get the mysql engine
        echo -e "\n##  Adding IUS, epel-release and MariaDB repositories.";
        log "yum -y install wget epel-release"
        log "yum -y install https://centos7.iuscommunity.org/ius-release.rpm"
        log "rpm --import /etc/pki/rpm-gpg/IUS-COMMUNITY-GPG-KEY"

        #Install PHP and other requirements
        echo "##  Installing httpd, PHP, MariaDB and other requirements.";
        PACKAGES="httpd mariadb-server git unzip php71u php71u-mysqlnd php71u-bcmath php71u-cli php71u-common php71u-embedded php71u-gd php71u-mbstring php71u-mcrypt php71u-ldap php71u-json php71u-simplexml"

        for p in $PACKAGES;do
            if isinstalled "$p"; then
                echo " ## $p already installed"
            else
                echo -n " ## Installing $p ... "
                log "yum -y install $p"
            echo "";
            fi
        done;

        echo -e "\n##  Cloning Snipe-IT from github to the web directory.";

        log "git clone https://github.com/snipe/snipe-it $webdir/$name"

        # Make mariaDB start on boot and restart the daemon
        echo "##  Starting the MariaDB server.";
        systemctl enable mariadb.service
        systemctl start mariadb.service

        echo "##  Securing MariaDB server.";
        echo "";
        echo "";
        /usr/bin/mysql_secure_installation

        echo "##  Creating MariaDB Database/User."
        echo "##  Please Input your MariaDB root password "
        mysql -u root -p --execute="CREATE DATABASE snipeit;GRANT ALL PRIVILEGES ON snipeit.* TO snipeit@localhost IDENTIFIED BY '$mysqluserpw';"

        ##TODO make sure the apachefile doesnt exist isnt already in there

        #Create the new virtual host in Apache and enable rewrite
        apachefile="/etc/httpd/conf.d/$name.conf"

        {
            echo "##  Creating the new virtual host in Apache.";
            echo ""
            echo ""
            echo "LoadModule rewrite_module modules/mod_rewrite.so"
            echo ""
            echo "<VirtualHost *:80>"
            echo "ServerAdmin webmaster@localhost"
            echo "    <Directory $webdir/$name/public>"
            echo "        Allow From All"
            echo "        AllowOverride All"
            echo "        Options +Indexes"
            echo "   </Directory>"
            echo "    DocumentRoot $webdir/$name/public"
            echo "    ServerName $fqdn"
            echo "        ErrorLog /var/log/httpd/snipeIT.error.log"
            echo "        CustomLog /var/log/access.log combined"
            echo "</VirtualHost>"
        } >> "$apachefile"

        ##TODO make sure this isnt already in there
        echo "##  Setting up hosts file.";
        echo >> $hosts "127.0.0.1 $hostname $fqdn"

        echo "##  Starting the apache server.";
        # Make apache start on boot and restart the daemon
        systemctl enable httpd.service
        systemctl restart httpd.service

        echo "##  Configuring .env file."
        tzone=$(timedatectl | gawk -F'[: ]' ' $9 ~ /zone/ {print $11}');
        setenv

        echo "##  Installing and running composer."
        cd $webdir/$name
        curl -sS https://getcomposer.org/installer | php
        php composer.phar install --no-dev --prefer-source

        #Set permissions
        perms
        chown -R apache:apache $webdir/$name

        #Check if SELinux is enforcing
        if [ "$(getenforce)" == "Enforcing" ]; then
            echo "##  Configuring SELinux."
            #Required for ldap integration
            setsebool -P httpd_can_connect_ldap on
            #Sets SELinux context type so that scripts running in the web server process are allowed read/write access
            chcon -R -h -t httpd_sys_script_rw_t $webdir/$name/
        fi

        systemctl restart httpd.service

        echo "##  Generating the application key."
        php artisan key:generate --force

        echo "##  Artisan Migrate."
        php artisan migrate --force

        echo "##  Creating scheduler cron."
        (crontab -l ; echo "* * * * * /usr/bin/php $webdir/$name/artisan schedule:run >> /dev/null 2>&1") | crontab -
    
    else
        echo "Unable to Handle Centos Version #.  Version Found: " $version
        return 1
    fi
esac

echo ""
echo "  ***If you want mail capabilities, edit $webdir/$name/.env***"
echo ""
echo "  ***Open http://$fqdn to login to Snipe-IT.***"
echo ""
echo ""
echo "* Cleaning up..."
rm -f snipeit.sh
rm -f install.sh
rm -rf ${tmp:?}
echo "* Finished!"
sleep 1
