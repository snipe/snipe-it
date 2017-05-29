FROM rethinkdb:latest

MAINTAINER Cristian Mello <cristianc.mello@gmail.com>

VOLUME /data/rethinkdb_data

RUN cp /etc/rethinkdb/default.conf.sample /etc/rethinkdb/instances.d/instance1.conf

CMD ["rethinkdb", "--bind", "all"]

EXPOSE 8080
