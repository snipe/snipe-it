wget https://raw.githubusercontent.com/merid14/snipe-it/develop/snipeit.sh
chmod 744 snipeit.sh
./snipeit.sh "$@" 2>&1 | tee /var/log/snipeit-install.log
sudo ./snipeit.sh