[![Click here to lend your support to: Snipe IT - Free Open Source Asset Management System and make a donation at pledgie.com](https://pledgie.com/campaigns/22899.png?skin_name=chrome)](https://pledgie.com/campaigns/22899) [![Build Status](https://travis-ci.org/snipe/snipe-it.svg?branch=develop)](https://travis-ci.org/snipe/snipe-it) [![Stories in Ready](https://badge.waffle.io/snipe/snipe-it.png?label=ready&title=Ready)](http://waffle.io/snipe/snipe-it)

## Snipe-IT - Asset Management For the Rest of Us

This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, handling software licenses, etc.

It is built on [Laravel 4.1](http://laravel.com) and uses the [Sentry 2](https://github.com/cartalyst/sentry) package.

Many thanks to the [Laravel 4 starter site](https://github.com/brunogaspar/laravel4-starter-kit) for a quick start.

This project is being actively developed (at what seems like breakneck speed sometimes!) We're still in alpha release, so this is NOT recommended for production use yet, as many more things will likely change before v1.0-stable is ready - but we're [releasing quite frequently](https://github.com/snipe/snipe-it/releases).

### Bug Reports & Feature Requests

Feel free to check out the [GitHub Issues for this project](https://github.com/snipe/snipe-it/issues) to open a bug report or see what open issues you can help with. Please search through existing issues (open and closed) to see if your question hasn't already been answered before opening a new issue.

We use Waffle.io to help better communicate our roadmap with users. Our [project page there](http://waffle.io/snipe/snipe-it) will show you the backlog, what's ready to be worked on, what's in progress, and what's completed.

[![Stories in Ready](https://badge.waffle.io/snipe/snipe-it.png?label=ready&title=Ready)](http://waffle.io/snipe/snipe-it)

-----

## Requirements

- PHP 5.4 or later
- MCrypt PHP Extension

-----

## Important Note on Updating

Whenever you pull down a new version from master or develop, when you grab the [latest official release](https://github.com/snipe/snipe-it/releases), make sure to run the following commands via command line:

	php composer.phar dump-autoload
	php artisan migrate

Forgetting to do this can mean your DB might end up out of sync with the new files you just pulled, or you may have some funky cached autoloader values. It's a good idea to get into the habit of running these every time you pull anything new down. If there are no database changes to migrate, it won't hurt anything to run migrations anyway.

-----

## How to Install

### 1) Downloading
#### 1.1) Clone the Repository

	git clone https://github.com/snipe/snipe-it your-folder

#### 1.2) Download the Repository

	https://github.com/snipe/snipe-it/archive/master.zip

-----

### 2) Setup Environment, Database and Mail Settings

#### 2.1) Adjust Environments

Update the file `boostrap/start.php` under the section `Detect The Application Environment`.

	vi bootstrap/start.php

-----

__AS OF LARAVEL 4.1__
Per the [Laravel 4.1 upgrade docs](http://laravel.com/docs/upgrade):

__*"For security reasons, URL domains may no longer be used to detect your application environment. These values are easily spoofable and allow attackers to modify the environment for a request. You should convert your environment detection to use machine host names (hostname command on Mac & Ubuntu)."*__

To find out your local machine's hostname, type `hostname` from a terminal prompt on the machine you're installing it on. The command-line response is that machine's hostname. Please note that the hostname is NOT always the same as the domain name.

So for example, if you're installing this locally on your Mac named SnipeMBP, the environmental variable section of `bootstrap/start.php` might look like this:

	$env = $app->detectEnvironment(array(
		'local'		 	=> array('SnipeMBP'),
		'staging' 		=> array('staging.mysite.com'),
		'production' 	=> array('www.mysite.com')
	));

If your development, staging and production sites all run on the same server (which is generally a terrible idea), [see this example](http://words.weareloring.com/development/setting-up-multiple-environments-in-laravel-4-1/) of how to configure the app using environmental variables.

-----

#### 2.2) Setup Your Database

Copy the example database config `app/config/local/database.example.php` to `app/config/local/database.php`.
Update the file `app/config/local/database.php` with your database name and credentials.

    vi app/config/local/database.php


#### 2.3) Setup Mail Settings

Copy the example mail config `app/config/local/mail.example.php` to `app/config/local/mail.php`.
Update the file `app/config/local/mail.php` with your mail settings.

    vi app/config/local/mail.php

This will be used to send emails to your users, when they register and they request a password reset.

#### 2.4) Adjust the application settings.

Copy the example app config `app/config/local/app.example.php` to `app/config/local/app.php`.

Update the file `app/config/local/app.php` with your URL settings.

	vi app/config/local/app.php

You should also change your secret key here -- if you prefer to have your key randomly generated, run the artisan key:generate command from the application root.

	php artisan key:generate --env=local


#### 2.5) Additional Adjustments

The app is configured to automatically detect if you're in a local, staging, or production environment.  Before deploying to a staging or production environment, follow sets 2.1, 2.2, and 2.3 above to tweak each environment as necessary.  Configuration files for each environment can be found in app/config/{environment} (local, staging, and production).

-----

### 3) Install the Dependencies via Composer
##### 3.1) If you don't have composer installed globally

	cd your-folder
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install

##### 3.2) For global composer installations

	cd your-folder
	composer install

-----

### 4) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install

-----

### 6) Fix permissions

You'll need to make sure that the `app/storage` directory is writable by your webserver, since caches and log files get written there. You should use the minimum permissions available for writing, based on how you've got your webserver configured.

	chmod -R 755 app/storage

If you still run into a permissions error, you may need to increase the permissions to 775, or twiddle your user/group permissions on your server.

	chmod -R 775 app/storage

-----

### 7) Set the correct document root for your server

The document root for the app should be set to the public directory. In a standard Apache virtualhost setup, that might look something like this on a standard linux LAMP stack:

	<VirtualHost *:80>
		<Directory /var/www/html/public>
			AllowOverride All
		</Directory>
		DocumentRoot /var/www/html/public
	    	ServerName www.example.org

	    	# Other directives here
	</VirtualHost>

An OS X virtualhost setup could look more like:

	Directory "/Users/flashingcursor/Sites/snipe-it/public/">
	Allow From All
	AllowOverride All
	Options +Indexes
	</Directory>
	<VirtualHost *:80>
	        ServerName "snipe-it.dev"
	        DocumentRoot "/Users/flashingcursor/Sites/snipe-it/public"
	SetEnv LARAVEL_ENV development
	</VirtualHost>

-----

### 8) Seed the Database

Loading up the sample data will give you an idea of how this should look, how your info should be structured, etc. It only pre-loads a handful of items, so you won't have to spend an hour deleting sample data.

	php artisan db:seed

-----


## Optional Development Stuff
### Set up the debugbar

In dev mode, I use the fabulous [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) by @barryvdh. After you've installed/updated composer, you'll need to publish the assets for the debugbar:

	php artisan debugbar:publish

The profiler is enabled by default if you have debug set to true in your app.php. You certainly don't have to use it, but it's pretty handy for troubleshooting queries, seeing how much memory your pages are using, etc.

-----

### Purging the autoloader

If you're doing any development on this, make sure you purge the auto-loader if you see any errors stating the new model you created can't be found, etc, otherwise your new models won't be grokked.

	php composer.phar dump-autoload


-----

### Application logs

Application logs for this app are found in `app/storage/logs`, as is customary of Laravel.

-----

### Running this on an EC2 Micro Instance

Depending on your needs, you could probably run this system in an EC2 micro instance. It doesn't take up very much memory and typically won't be a super-high-traffic application. EC2 micros fall into the free/dirt-cheap tier, which might make this a nice option. One thing to note though - composer can be a little memory-intensive while you're running updates, and you may have trouble with it failing on a micro. You can crank the memory_limit up in php.ini, but EC2 micros have swap disabled by default, so even that may not cut it. If you run into totally unhelpful error messages while running composer updates (like simply 'Killed') or fatal memory issues mentioning phar, your best bet will be to enable swap:

	sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
	sudo /sbin/mkswap /var/swap.1
	sudo /sbin/swapon /var/swap.1

If you need more than 1024 then change that to something higher.

To enable it by default after reboot, add this line to /etc/fstab:

	/var/swap.1 swap swap defaults 0 0

-----

## License

	Copyright (C) 2013 Alison Gianotto - snipe@snipe.net

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

