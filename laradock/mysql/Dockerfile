FROM mysql:5.7

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

RUN chown -R mysql:root /var/lib/mysql/

ADD my.cnf /etc/mysql/conf.d/my.cnf

CMD ["mysqld"]

EXPOSE 3306
