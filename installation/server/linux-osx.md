---
currentMenu: linux-osx
---

# Linux/OSX

<div id="generated-toc"></div>


## Set the correct document root for your server with Apache

The document root for the app should be set to the `public` directory. In a standard Apache virtualhost setup, that might look something like this on a standard linux LAMP stack:

```
	<VirtualHost *:80>
		<Directory /var/www/html/public>
			AllowOverride All
		</Directory>
		DocumentRoot /var/www/html/public
	    	ServerName www.yourserver.com
	    	# Other directives here
	</VirtualHost>
```

An OS X virtualhost setup could look more like:

```
	<Directory "/Users/youruser/Sites/snipe-it/public/">
		Allow From All
		AllowOverride All
		Options +Indexes
	</Directory>
	<VirtualHost *:80>
		ServerName "www.yourserver.com"
		DocumentRoot "/Users/youruser/Sites/snipe-it/public"
	SetEnv LARAVEL_ENV development
	</VirtualHost>
```

Snipe-IT requires `mod_rewrite` to be installed and enabled on systems running Apache. For more information on how to set up `mod_rewrite`, [click here](http://xmodulo.com/2013/01/how-to-enable-mod_rewrite-in-apache2-on-debian-ubuntu.html).

Note that in Apache 2.4, you may need to use `Require all granted` instead of `Allow From All`.

## Setting up the site configuration for your server with Nginx and PHP-FPM

In order to work, PHP-FPM will need to be installed and setup to listen on a socket.  For more information on how to setup PHP-FPM, [click here](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-12-04#step-five—configure-php).

```
	server {
	    listen 80;
	    server_name localhost;

	    root /Users/youruser/Sites/snipe-it/public/;
	    index index.php index.html index.htm;

	    location / {
	        try_files $uri $uri/ /index.php$is_args$args;
	    }

	    location ~ \.php$ {
	        try_files $uri $uri/ =404;
	        fastcgi_pass unix:/var/run/php5-fpm-www.sock;
	        fastcgi_index index.php;
	        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	        include fastcgi_params;
	    }
	}
```

If you prefer to use a forced SSL setup, you can use the following configuration instead.

```
	server {
	    listen 80;
	    server_name localhost;

	    return 301 https://$server_name$request_uri;
	}

	server {
	    listen 443 ssl;
	    server_name localhost;

	    ssl_certificate /path/to/your.crt;
	    ssl_certificate_key /path/to/your.key;
	    ssl_protocols SSLv3 TLSv1 TLSv1.1 TLSv1.2;
	    ssl_prefer_server_ciphers on;
	    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-RC4-SHA:ECDHE-RSA-AES256-SHA:DHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA:RC4-SHA:!aNULL:!eNULL:!EXPORT:!DES:!3DES:!MD5:!DSS:!PKS;
	    ssl_session_timeout 5m;
	    ssl_session_cache builtin:1000 shared:SSL:10m;

	    root /Users/youruser/Sites/snipe-it/public/;
	    index index.php index.html index.htm;

	    location / {
	        try_files $uri $uri/ /index.php$is_args$args;
	    }

	    location ~ \.php$ {
	        try_files $uri $uri/ =404;
	        fastcgi_pass unix:/var/run/php5-fpm-www.sock;
	        fastcgi_index index.php;
	        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	        include fastcgi_params;
	    }
	}
```

Note that with the SSL configuration you will need to adjust the path to your SSL certificate or it will not work.  You can use a proper certificate generated from a CA or a self-signed certificate.  For more information on creating a self-signed certificate, [click here](https://www.digitalocean.com/community/tutorials/how-to-create-a-ssl-certificate-on-nginx-for-ubuntu-12-04).

-----

## Seed the Database

Loading up the sample data will give you an idea of how this should look, how your info should be structured, etc. It only pre-loads a handful of items, so you won't have to spend an hour deleting sample data.

	php artisan db:seed

__If you run this command on a database that already has your own asset data in it, it will over-write your database. ALL of your data will be gone. NEVER run the db seeder on production after on your initial install.__

-----

## Application logs

Application logs for this app are found in `app/storage/logs`, as is customary of Laravel.

-----

## Running this on an EC2 Micro Instance

Depending on your needs, you could probably run this system in an EC2 micro instance. It doesn't take up very much memory and typically won't be a super-high-traffic application. EC2 micros fall into the free/dirt-cheap tier, which might make this a nice option. One thing to note though - composer can be a little memory-intensive while you're running updates, and you may have trouble with it failing on a micro. You can crank the memory_limit up in php.ini, but EC2 micros have swap disabled by default, so even that may not cut it. If you run into totally unhelpful error messages while running composer updates (like simply 'Killed') or fatal memory issues mentioning phar, your best bet will be to enable swap:

	sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
	sudo /sbin/mkswap /var/swap.1
	sudo /sbin/swapon /var/swap.1

If you need more than 1024MB then change that to something higher.

To enable it by default after reboot, add this line to /etc/fstab:

	/var/swap.1 swap swap defaults 0 0

-----
## Developing & Contributing

Please be sure to see the [contributing guidelines](https://github.com/snipe/snipe-it/blob/develop/CONTRIBUTING.md) before submitting pull requests.

The only real difference in setting Snipe-IT up for local development versus setting it up for production usage is the configuration files, and remembering to add the local environment flag on the artisan commands.

You'll notice in your `app/config` directory, you have directories such as `local`, `staging`, and `production`. (The `testing` directory is reserved for unit tests, so don't mess with that one.)

You'll want to make sure you have the configuration files updated for whichever environment you're in, which will most likely be `local`.

If you run the command line tools without the local flag, it will default to the production environment, so you'll want to make sure you run the commands as:

	php artisan key:generate --env=local
	php artisan app:install --env=local

### Set up the debugbar

In dev mode, I use the fabulous [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) by [barryvdh](https://github.com/barryvdh). After you've installed/updated composer, you'll need to publish the assets for the debugbar:

	php artisan debugbar:publish

The profiler is enabled by default if you have debug set to true in your app.php. You certainly don't have to use it, but it's pretty handy for troubleshooting queries, seeing how much memory your pages are using, etc.

-----

### Purging the autoloader

If you're doing any development on this, make sure you purge the auto-loader if you see any errors stating the new model you created can't be found, etc, otherwise your new models won't be grokked.

	php composer.phar dump-autoload

-----
