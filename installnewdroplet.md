
1) CREATE A SUDO USER

adduser snipeit
usermod -aG sudo snipeit
su - snipeit

2) RUN THE FOLLOWING COMMANDS AS A SUDO USER
https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-18-04#step-1-%E2%80%94-installing-phpmyadmin

sudo wget https://raw.githubusercontent.com/luism123mb/snipe-it/master/snipeit.sh
sudo chmod 744 snipeit.sh
sudo ./snipeit.sh 2>&1 | tee -a /var/log/snipeit-install.log

3) INSTALL PHPMYADMIN

sudo apt install phpmyadmin php-mbstring php-gettext
sudo systemctl restart apache2


4) OPEN THE DATABASE FILE USING ATOM AND DELETE STDF_

5) INPORT THE DATABASE ON SNIPEIT DATABASE


////////////RE RUN OLD DROPLET ////////////
1)DELET EVERYTHING WITH INSTALLING PAKCAGES AND MARIADB, JUST LEAVE APACHE STUFF ON THE SNIPEIT.SH  FILE LEAVE ANYTHING ELSE, AND COMPARE TO THE REAL FILE FOR DEBUGING
2)COPY THE IP FROM DROPLET OR SERVER AND PASS IT
3)COPY PASSWORD FROM OLD .ENV FILE
4) GO TO PHP MY ADMIN USERS TO FIND LOGING DETAILS ( PHPMYADMIN LOGING USER:SAMMY, PW: PASSWORD)
5)ENJOY

////////////////FREE SSL SERTIFICATE INSTALL ON APACHE/////////

https://www.tecmint.com/install-free-lets-encrypt-ssl-certificate-for-apache-on-debian-and-ubuntu/
NOTE: make sure you put the domain on the line of code

 sudo a2enmod ssl
 sudo a2ensite default-ssl.conf
 sudo service apache2 restart
 cd /usr/local
 sudo git clone https://github.com/letsencrypt/letsencrypt
 cd /usr/local/letsencrypt
 sudo ./letsencrypt-auto --apache -d your_domain.tld
 ******NOTE: make sure you put the domain on the line of code********
 *********** Multuple domain *************
 sudo ./letsencrypt-auto --apache -d your_domain.tld  -d www. your_domain.tld
 sudo ls /etc/letsencrypt/live
Finally, to verify the status of your SSL Certificate visit the following link. Replace the domain name accordingly.
https://www.ssllabs.com/ssltest/analyze.html?d=your_domain.tld&latest

****Redirect DNS*****
Point A to DNS in other server, add the domain to the other server on the A record
