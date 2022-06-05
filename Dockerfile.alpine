FROM alpine:3.14.2
# Apache + PHP
RUN  apk add --no-cache \
        apache2 \
        php7 \
        php7-common \
        php7-apache2 \
        php7-curl \
        php7-ldap \
        php7-mysqli \
        php7-gd \
        php7-xml \
        php7-mbstring \
        php7-zip \
        php7-ctype \
        php7-tokenizer \
        php7-pdo_mysql \
        php7-openssl \
        php7-bcmath \
        php7-phar \
        php7-json \
        php7-iconv \
        php7-fileinfo \
        php7-simplexml \
        php7-session \
        php7-dom \
        php7-xmlwriter \
        php7-xmlreader \
        php7-sodium \
        php7-redis \
        curl \
        wget \
        vim \
        git \
        mysql-client \
        tini

COPY docker/column-statistics.cnf /etc/mysql/conf.d/column-statistics.cnf

# Where apache's PID lives
RUN mkdir -p /run/apache2 && chown apache:apache /run/apache2

RUN sed -i 's/variables_order = .*/variables_order = "EGPCS"/' /etc/php7/php.ini
COPY  docker/000-default-2.4.conf /etc/apache2/conf.d/default.conf

# Enable mod_rewrite
RUN sed -i '/LoadModule rewrite_module/s/^#//g' /etc/apache2/httpd.conf

COPY . /var/www/html

WORKDIR /var/www/html

COPY docker/docker.env /var/www/html/.env

RUN chown -R apache:apache /var/www/html

RUN \
	rm -r "/var/www/html/storage/private_uploads" \
	&& mkdir -p "/var/lib/snipeit/data/private_uploads" && ln -fs "/var/lib/snipeit/data/private_uploads" "/var/www/html/storage/private_uploads" \
    && rm -rf "/var/www/html/public/uploads" \
    && mkdir -p "/var/lib/snipeit/data/uploads" && ln -fs "/var/lib/snipeit/data/uploads" "/var/www/html/public/uploads" \
    && mkdir -p "/var/lib/snipeit/dumps" && rm -r "/var/www/html/storage/app/backups" && ln -fs "/var/lib/snipeit/dumps" "/var/www/html/storage/app/backups" \
    && mkdir -p "/var/lib/snipeit/keys" && ln -fs "/var/lib/snipeit/keys/oauth-private.key" "/var/www/html/storage/oauth-private.key" \
    && ln -fs "/var/lib/snipeit/keys/oauth-public.key" "/var/www/html/storage/oauth-public.key" \
    && chown -hR apache "/var/www/html/storage/" \
    && chown -R apache "/var/lib/snipeit"

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN mkdir -p /var/www/.composer && chown apache /var/www/.composer

# Install dependencies
USER apache
RUN COMPOSER_CACHE_DIR=/dev/null composer install --no-dev --working-dir=/var/www/html

USER root

VOLUME ["/var/lib/snipeit"]

# Entrypoints
COPY docker/entrypoint_alpine.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/sbin/tini", "--"]

CMD ["/entrypoint.sh"]

EXPOSE 80