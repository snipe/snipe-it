FROM adminer:4.3.0

# Version 4.3.1 contains PostgreSQL login errors. See docs.
# See https://sourceforge.net/p/adminer/bugs-and-features/548/

MAINTAINER Patrick Artounian <partounian@gmail.com>

# Add volume for sessions to allow session persistence
VOLUME /sessions

#####################################
# SQL SERVER:
#####################################
USER root
ARG INSTALL_MSSQL=false
ENV INSTALL_MSSQL ${INSTALL_MSSQL}
RUN if [ ${INSTALL_MSSQL} = true ]; then \
  set -xe \
  && apk --update add --no-cache --virtual .phpize-deps $PHPIZE_DEPS unixodbc unixodbc-dev \
  && pecl channel-update pecl.php.net \
  && pecl install pdo_sqlsrv-4.1.8preview sqlsrv-4.1.8preview \
  && echo "extension=sqlsrv.so" > /usr/local/etc/php/conf.d/20-sqlsrv.ini \
  && echo "extension=pdo_sqlsrv.so" > /usr/local/etc/php/conf.d/20-pdo_sqlsrv.ini \
;fi

USER adminer

# We expose Adminer on port 8080 (Adminer's default)
EXPOSE 8080
