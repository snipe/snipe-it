wget https://raw.githubusercontent.com/merid14/snipe-it/develop/snipeit.sh
chmod 744 snipeit.sh
# ensure running as root
if [ "$(id -u)" != "0" ]; then
  exec sudo "$0" "$@"
fi
./snipeit.sh 2>&1 | sudo tee -a /var/log/snipeit-install.log