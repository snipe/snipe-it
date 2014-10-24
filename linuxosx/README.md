# Linux/OSX


Note: Installation for Windows IIS [can be found here](https://gist.github.com/madd15/e48a9c4aaa4b14b6f69a) (thanks, [madd15](https://github.com/madd15)!)

-----

### 1) Setup Environment, Database and Mail Settings

#### 1.1) Adjust Environments

Update the file `bootstrap/start.php` under the section `Detect The Application Environment`.

__AS OF LARAVEL 4.1__
Per the [Laravel 4.1 upgrade docs](http://laravel.com/docs/upgrade):

__*"For security reasons, URL domains may no longer be used to detect your application environment. These values are easily spoofable and allow attackers to modify the environment for a request. You should convert your environment detection to use machine host names (hostname command on Mac & Ubuntu)."*__

To find out your local machine's hostname, type `hostname` from a terminal prompt on the machine you're installing it on. The command-line response is that machine's hostname. Please note that the hostname is NOT always the same as the domain name.

So for example, if you're installing this on your server named www.yourserver.com, the environmental variable section of `bootstrap/start.php` might look like this:

	$env = $app->detectEnvironment(array(
		...
		'production' 	=> array('www.yourserver.com')
	));

If your development, staging and production sites all run on the same server (which is generally a terrible idea), [see this example](http://words.weareloring.com/development/setting-up-multiple-environments-in-laravel-4-1/) of how to configure the app using environmental variables.

-----

#### 1.2) Setup Your Database

Copy the example database config `app/config/production/database.example.php` to `app/config/production/database.php`.
Update the file `app/config/production/database.php` with your database name and credentials:

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'snipeit_laravel',
            'username'  => 'travis',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),


Note: You must create the database youself. Snipe-IT does not create the database or database users for you.


#### 1.3) Setup Mail Settings

Copy the example mail config `app/config/production/mail.example.php` to `app/config/production/mail.php`.
Update the file `app/config/production/mail.php` with your mail settings.

This will be used to send emails to your users, when they register and when they request a password reset.

#### 1.4) Adjust the application settings.

Copy the example app config `app/config/production/app.example.php` to `app/config/production/app.php`.

Update the file `app/config/production/app.php` with your URL settings.

    'url' => 'http://www.yourserver.com',

You should also change your secret key here -- if you prefer to have your key randomly generated, run the artisan key:generate command from the application root.

	php artisan key:generate --env=production

-----

### 2) Install the Dependencies via Composer
##### 2.1) If you don't have composer installed globally

	cd your-folder
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install

##### 2.2) For global composer installations

	cd your-folder
	composer install

-----

### 3) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install

-----

### 4) Fix permissions

You'll need to make sure that the `app/storage` directory is writable by your webserver, since caches and log files get written there. You should use the minimum permissions available for writing, based on how you've got your webserver configured.

	chmod -R 755 app/storage

If you still run into a permissions error, you may need to increase the permissions to 775, or twiddle your user/group permissions on your server.

	chmod -R 775 app/storage
	
Note: It should go without saying, but make sure the Snipe-IT project directory is not owned by `root`. Your webserver should be running as your webserver's user (often `apache`, `nobody`, or `www-data`). But never, ever `root`. Ever.


-----

### 5) Settings up your web server

##### 5.1) Set the correct document root for your server with Apache

The document root for the app should be set to the `public` directory. In a standard Apache virtualhost setup, that might look something like this on a standard linux LAMP stack:

	<VirtualHost *:80>
		<Directory /var/www/html/public>
			AllowOverride All
		</Directory>
		DocumentRoot /var/www/html/public
	    	ServerName www.yourserver.com
	    	# Other directives here
	</VirtualHost>

An OS X virtualhost setup could look more like:

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

Snipe-IT requires `mod_rewrite` to be installed and enabled on systems running Apache. For more information on how to set up `mod_rewrite`, [click here](http://xmodulo.com/2013/01/how-to-enable-mod_rewrite-in-apache2-on-debian-ubuntu.html).

Note that in Apache 2.4, you may need to use `Require all granted` instead of `Allow From All`.

##### 5.2) Setting up the site configuration for your server with Nginx and PHP-FPM

In order to work, PHP-FPM will need to be installed and setup to listen on a socket.  For more information on how to setup PHP-FPM, [click here](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-12-04#step-five—configure-php).

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

If you prefer to use a forced SSL setup, you can use the following configuration instead.

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

Note that with the SSL configuration you will need to adjust the path to your SSL certificate or it will not work.  You can use a proper certificate generated from a CA or a self-signed certificate.  For more information on creating a self-signed certificate, [click here](https://www.digitalocean.com/community/tutorials/how-to-create-a-ssl-certificate-on-nginx-for-ubuntu-12-04).

-----

### 6) Seed the Database

Loading up the sample data will give you an idea of how this should look, how your info should be structured, etc. It only pre-loads a handful of items, so you won't have to spend an hour deleting sample data.

	php artisan db:seed

__If you run this command on a database that already has your own asset data in it, it will over-write your database. ALL of your data will be gone. NEVER run the db seeder on production after on your initial install.__

-----

### Application logs

Application logs for this app are found in `app/storage/logs`, as is customary of Laravel.

-----

### Running this on an EC2 Micro Instance

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



