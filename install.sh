wget https://raw.githubusercontent.com/merid14/snipe-it/develop/snipeit.sh
chmod 744 snipeit.sh
sudo ./snipeit.sh 2>&1 | sudo tee -a /var/log/snipeit-install.log