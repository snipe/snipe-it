#!/bin/bash

#docker run -v docker start mysql
# docker run --name snipe-mysql -e MYSQL_ROOT_PASSWORD=fartwingus -e MYSQL_DATABASE=snipeit -e MYSQL_USER=snipeit -e MYSQL_PASSWORD=whateverdood -d mysql
docker run -d snipe-mysql
docker run -d -v ~/Documents/snipeyhead/snipe-it/:/var/www/html -p $(boot2docker ip)::80   --link snipe-mysql:mysql --name=snipeit snipeit
