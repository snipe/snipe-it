#### How to use the Snipe-IT docker image #####

The easiest way, by far, is to just use the version we push to the docker hub:

```sh
docker pull snipe/snipe-it
```

Then you have a functioning Snipe-IT container. Skip ahead to "How to get up and 
running" to configure it and get it connected to your database.

#### How to *Build* the Snipe-IT docker image ####

Build the snipeit image using the ```Dockerfile``` at the root directory of Snipe-IT by doing this:

```sh
docker build -t snipe-it .
```

Then you can use your newly built image as ```snipe-it```

### How to get up and running ###

* The best way to handle all of the various settings for your various containers is to use an `env-file`. 
See the Docker documentation for more details. It should be just a simple text file with environment 
variable names and values, separated by ```=``` signs.

Your docker.env should look something like this:

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
* First get a MySQL container running. MySQL 5.6 or earlier are easiest.

```sh
docker run --name snipe-mysql --env-file=my_env_file -d -p $(docker-machine ip b2d)::3306 mysql-56
```

**WARNING:** Newer MySQL containers (5.7 and later, or MariaDB) may run in strict-mode by default, and the initial
migrations and appliction setup will fail in strict mode. You need to disable it
first!

That should set you up with your database to use. (You can also specify environment variables on the command-line instead of the env-file, but that can get very clunky very quickly; see ```docker run --help``` for details)

* If your Email solution requires its own container, start that container or service. Make sure to expose port 587 for mail submission, and use ```--link mail:...```.

Now you can start your Snipe-IT container -
```sh
docker run -d -p $(docker-machine ip b2d)::80 --name="snipeit" --link snipe-mysql:mysql --env-file=my_env_file snipe-it 
```
If you have a separate container running for email, you will also want a ```--link``` setting for email as well.

You can find out what port Snipe-IT is running on with:

```sh
docker port snipe-it
```

And finally, you can initialize the application and database like this:

```sh
docker exec -i -t snipe-it php artisan app:install
```

(Go ahead and answer the questions however you like. Type 'yes' when asked whether or not you want to run migrations.)

**WARNING:** Docker wants to treat containers as 'ephemeral' - but Snipe-IT is
expecting to be able to save uploaded images and files to the local filesystem.
Either make sure to back up your image, or mount a local directory to house
uploaded files at /var/www/blah/

~~#NOTE:~~

~~You may have to run:~~

```sh
~~docker exec -i -t snipeit php artisan key:generate --env=production~~
```

~~to get the production application key set correctly; I'm not yet sure why this is (I think it's a bug?)~~

# ~~If you want to seed~~

~~You can load out some initial data into the DB if you like by doing this:~~

```sh
~~docker -p $(boot2docker ip):8000:80 --link mysql:mysql php artisan db:seed~~
```

~~This already happens~~

### For Development ###

When you call ```docker run``` - make sure to mount your own snipe-it directory *over* the /var/www/html directory. Something like:

```sh
docker run -d -v /Path/To/My/snipe-it/checkout:/var/www/html -p $(boot2docker ip)::80  --name="snipeit" --link mysql:mysql snipeit
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
