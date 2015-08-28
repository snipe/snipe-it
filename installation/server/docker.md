---
currentMenu: docker
---

# Installing Snipe-IT on Docker

<div id="generated-toc" class="generate_from_h2"></div>

Build the snipeit image using the Dockerfile at the root directory of Snipe-IT by doing this:

```
docker build -t snipeit .
```

Then you can use your newly built image as `snipeit`.

## How to get up and running

First get a MySQL container running...

Figure out what you want for your:

- MySQL root password
- MySQL Database name for Snipe-IT
- MySQL User name for the user who will access Snipe-IT
- MySQL Password for that user

```
docker run --name mysql -e MYSQL_ROOT_PASSWORD=SUPERDUPERSECRETPASSWORD -e MYSQL_DATABASE=snipeit -e MYSQL_USER=snipeit -e MYSQL_PASSWORD=tinglewingler -d -p $(boot2docker ip)::3306 mysql
```

That should set you up with your database to use. (You can also use an environment file using `--env-file`; see `docker run --help` for details)

You will want to set the URL that will be used to access the server. This value is used as the URL for the dashboard page, as well as in emails.

- SERVER_URL – the server's URL (example: http://snipeit.example.com)

You'll want to handle E-Mail – you can do this with a Docker container (not documented here), or point to any other external mail server. If you did want to do it using Docker, make sure to expose port 587 for mail submission, and use `--link mail:...`.

Regardless, the environment variables necessary are:

- MAIL_PORT_587_TCP_ADDR – the hostname/IP address of your mailserver
- MAIL_PORT_587_TCP_PORT – the port for the mailserver (probably 587, could be another)
- MAIL_ENV_FROM_ADDR, MAIL_ENV_FROM_NAME – the default from address, and from name for emails
- MAIL_ENV_ENCRYPTION – pick ‘tls' for SMTP-over-SSL, ‘tcp' for unencrypted
- MAIL_ENV_USERNAME – SMTP username
- MAIL_ENV_PASSWORD – SMTP password

You can assemble these options into an env-file, or specify them on the command line when you run your Snipe-IT container.

Likewise, there are environment variables available to configure the (optional) LDAP support:

- LDAP_URL – the URL for your LDAP server (ldap://ldap.example.com)
- LDAP_USERNAME – LDAP 'browse' username
- LDAP_PASSWORD – LDAP 'browse' password
- LDAP_BASEDN – the base where the search for users will be executed
- LDAP_FILTER – the search filter for the LDAP query
- LDAP_RESULT_USERNAME – the LDAP field to use as the username
- LDAP_RESULT_LAST_NAME – the LDAP field to use as the last name
- LDAP_RESULT_FIRST_NAME – the LDAP field to use as the first name
- LDAP_RESULT_ACTIVE_FLAG – the LDAP field used to specify if the user is active (optional)
- LDAP_RESULT_EMP_NUM – the LDAP field used to specify the employee number (optional)
- LDAP_RESULT_EMAIL – the LDAP field used to specify the email address (optional)
- LDAP_AUTHENTICATION_FILTER_QUERY – the LDAP query to execute when authenticating a user (optional)

Now you can start your Snipe-IT container:

```
docker run -d -p $(boot2docker ip)::80 --name="snipeit" --link mysql:mysql [--env-file or -e options...] snipeit
```

You can find out what port Snipe-IT is running on with:

```
docker port snipeit
```

And finally, you can initialize the application and database like this:

```
docker exec -i -t snipeit php artisan app:install
```

(Go ahead and answer the questions however you like. Type `y` when asked whether or not you want to run migrations.)

NOTE:

You may have to run:

```
docker exec -i -t snipeit php artisan key:generate --env=production
```

to get the production application key set correctly.

If you want to seed

You can load out some initial data into the DB if you like by doing this:

```
~~docker -p $(boot2docker ip):8000:80 --link mysql:mysql php artisan db:seed~~
```

#### For Developers

When you call `docker run` – make sure to mount your own snipe-it directory over the ``/var/www/html` directory.

Something like:

```
docker run -d -v /Path/To/My/snipe-it/checkout:/var/www/html -p $(boot2docker ip)::80  --name="snipeit" --link mysql:mysql snipeit
```

Then your local changes to the code will be reflected. You will have to re-run `composer install`:

```
docker exec -i -t snipeit composer install
```

You'll need to copy the docker/database.php file to `app/config/production/` , and copy the `app/config/production/app.example.php` to `app/config/production/app.php`.

And also `app:install`:

```
docker exec -i -t snipeit php artisan app:install
```

And you may still need to generate the key with:

```
docker exec -i -t snipeit php artisan key:generate --env=production
```

While you're developing, you may need to occasionally run:

```
docker exec snipeit composer dump-autoload
```
