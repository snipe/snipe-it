---
currentMenu: docker
---

# Installing Snipe-IT on Docker

The easiest way, by far, is to just use the version we push to [Docker Hub](https://hub.docker.com/r/snipe/snipe-it/):

```sh
docker pull snipe/snipe-it
```

Then you have a functioning Snipe-IT container. Skip ahead to "How to get up and
running" to configure it and get it connected to your database.

## How to get up and running

The best way to handle all of the various settings for your various containers is to use an `env-file`.
See the Docker documentation for more details. It should be just a simple text file with environment
variable names and values, separated by ```=``` signs.

Your `docker.env` should look something like this:

```env
# Mysql Parameters
MYSQL_ROOT_PASSWORD=YOUR_SUPER_SECRET_PASSWORD
MYSQL_DATABASE=snipeit
MYSQL_USER=snipeit
MYSQL_PASSWORD=YOUR_snipeit_USER_PASSWORD

# Email Parameters
# - the hostname/IP address of your mailserver
MAIL_PORT_587_TCP_ADDR=smtp.whatever.com
#the port for the mailserver (probably 587, could be another)
MAIL_PORT_587_TCP_PORT=587
# the default from address, and from name for emails
MAIL_ENV_FROM_ADDR=youremail@yourdomain.com
MAIL_ENV_FROM_NAME=Your Full Email Name
# - pick 'tls' for SMTP-over-SSL, 'tcp' for unencrypted
MAIL_ENV_ENCRYPTION=tcp
# SMTP username and password
MAIL_ENV_USERNAME=your_email_username
MAIL_ENV_PASSWORD=your_email_password

# Snipe-IT Settings
SNIPEIT_TIMEZONE=UTC
SNIPEIT_LOCALE=en
SERVER_URL=https://myserver.com
```
First get a MySQL container running. MySQL 5.6 or earlier are easiest.

```sh
docker run --name snipe-mysql --env-file=my_env_file -d -p $(docker-machine ip b2d)::3306 mysql:5.6
```

**WARNING:** Newer MySQL containers (5.7 and later, or MariaDB) may run in strict-mode by default, and the initial migrations and application setup will fail in strict mode. If you want to use one of those versions, you need to disable strict mode first!

That should set you up with your database to use. (You can also specify environment variables on the command-line instead of the env-file, but that can get very clunky very quickly; see ```docker run --help``` for details)

* If your Email solution requires its own container, start that container or service. Make sure to expose port 587 for mail submission, and use ```--link mail:...```.

### Start your Snipe-IT container

First off, decide whether or not you want to have your Snipe-IT container manage SSL for you, or not.

#### SSL disabled

Start your Snipe-IT container -
```sh
docker run -d -p $(docker-machine ip b2d)::80 --name="snipeit" --link snipe-mysql:mysql --env-file=my_env_file snipe-it
```

#### SSL enabled
Start your Snipe-IT container - but make sure you can "mount" your local copies of your SSL key and SSL certificate onto the container.

They're expected to be named exactly: `/etc/ssl/private/snipeit-ssl.key` and `/etc/ssl/private/snipeit-ssl.crt` for the key and certificate, respectively.

```sh
docker run -d -P --name="snipeit" --link snipe-mysql:mysql -v /Absolute/Path/To/Your/SSL_Cert_directory:/etc/ssl/private --env-file=my_env_file snipe-it
```

### Email, Management, Access

If you have a separate container running for email, you will also want a ```--link``` setting for email as well.

You can find out what port Snipe-IT is running on with:

```sh
docker port snipeit
```

And finally, you can initialize the application and database like this:

```sh
docker exec -i -t snipeit php artisan app:install
```

(Go ahead and answer the questions however you like. Type 'yes' when asked whether or not you want to run migrations.)

## For Development

You can build the snipe-it image using the ```Dockerfile``` at the root directory of Snipe-IT by doing this:

```sh
docker build -t snipe-it .
```

Then you can use your newly built image as ```snipe-it```


When you call ```docker run``` - make sure to mount your own snipe-it directory *over* the /var/www/html directory. Something like:

```sh
docker run -d -v /Path/To/My/snipe-it/checkout:/var/www/html -p $(docker-machine ip b2d)::80  --name="snipeit" --link mysql:mysql snipeit
```

Then your local changes to the code will be reflected. You will have to re-run ```composer install``` -

```sh
docker exec -i -t snipeit composer install
```

You'll need to copy the docker/database.php file to ```app/config/production/``` , and copy the ```app/config/production/app.example.php to app/config/production/app.php```

And also app:install -

```sh
docker exec -i -t snipeit php artisan app:install
```

And you may still need to generate the key with -

```sh
docker exec -i -t snipeit php artisan key:generate --env=production
```
While you're developing, you may need to occasionally run -

```sh
docker exec snipeit composer dump-autoload
```

To fix the autoloading cache (if, for example, your class names change, or you add new ones...)

**NOTE: When upgrading your docker install, make a note of the app key in `app/config/production/app.php`. If you are using LDAP, your LDAP server password is encrypted using this app key, and you will have a bad time if your app key changes. The upgraded docker WILL change your app key, so just replace the newly created on with your old one. ** 
