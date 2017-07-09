FROM microsoft/mssql-server-linux

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

# Create config directory
# an set it as WORKDIR
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# Bundle app source
COPY . /usr/src/app

RUN chmod +x /usr/src/app/create_table.sh

ENV MSSQL_DATABASE=$MSSQL_DATABASE
ENV ACCEPT_EULA=Y
ENV SA_PASSWORD=$MSSQL_PASSWORD

VOLUME /var/opt/mssql

EXPOSE 1433

CMD /bin/bash ./entrypoint.sh
