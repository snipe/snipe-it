
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
