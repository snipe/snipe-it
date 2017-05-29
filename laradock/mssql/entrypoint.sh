#start SQL Server, start the script to create the DB and import the data, start the app
/opt/mssql/bin/sqlservr.sh & /usr/src/app/create_table.sh & tail -f /dev/null