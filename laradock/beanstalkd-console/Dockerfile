FROM php:latest

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

RUN apt-get update && apt-get install -y curl

RUN curl -sL https://github.com/ptrofimov/beanstalk_console/archive/master.tar.gz | tar xvz -C /tmp
RUN mv /tmp/beanstalk_console-master /source

RUN apt-get remove --purge -y curl && \
    apt-get autoclean && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 2080

CMD bash -c 'BEANSTALK_SERVERS=$BEANSTALKD_PORT_11300_TCP_ADDR:11300 php -S 0.0.0.0:2080 -t /source/public'
