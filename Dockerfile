FROM ubuntu
MAINTAINER Brady Wetherington <uberbrady@gmail.com>

RUN apt-get update && apt-get install -y \
apache2-bin \
libapache2-mod-php5 \
php5-curl \
php5-ldap \
php5-mysql \
php5-mcrypt \
php5-gd \
patch \
curl \
vim \
git 

RUN php5enmod mcrypt
RUN php5enmod gd

RUN sed -i 's/variables_order = .*/variables_order = "EGPCS"/' /etc/php5/apache2/php.ini
RUN sed -i 's/variables_order = .*/variables_order = "EGPCS"/' /etc/php5/cli/php.ini

RUN useradd --uid 1000 --gid 50 docker

RUN echo export APACHE_RUN_USER=docker >> /etc/apache2/envvars
RUN echo export APACHE_RUN_GROUP=staff >> /etc/apache2/envvars

COPY docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

COPY . /var/www/html

RUN a2enmod rewrite

############ INITIAL APPLICATION SETUP #####################

WORKDIR /var/www/html

#Append to bootstrap file (less brittle than 'patch')
RUN sed -i 's/return $app;/$env="production";\nreturn $app;/' bootstrap/start.php

#copy all configuration files
COPY docker/*.php /var/www/html/app/config/production/

RUN chown -R docker /var/www/html

############## DEPENDENCIES via COMPOSER ###################

#global install of composer
RUN cd /tmp;curl -sS https://getcomposer.org/installer | php;mv /tmp/composer.phar /usr/local/bin/composer

# Get dependencies
RUN cd /var/www/html;composer install

############### APPLICATION INSTALL/INIT #################

#RUN php artisan app:install
# too interactive! Try something else

#COPY docker/app_install.exp /tmp/app_install.exp
#RUN chmod +x /tmp/app_install.exp
#RUN /tmp/app_install.exp

##### START SERVER

CMD . /etc/apache2/envvars ;apache2 -DFOREGROUND

EXPOSE 80
