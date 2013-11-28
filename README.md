<a href='https://pledgie.com/campaigns/22899'><img alt='Click here to lend your support to: Snipe IT - Free Open Source Asset Management System and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/22899.png?skin_name=chrome' border='0' ></a>

## Snipe-IT - Asset Management For the Rest of Us

This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, handling software licenses, etc.

It is built on [Laravel 4](http://laravel.com) and uses the [Sentry 2](https://github.com/cartalyst/sentry) package.

Many thanks to the [Laravel 4 starter site](https://github.com/brunogaspar/laravel4-starter-kit) for a quick start.

This isn't actually ready for anyone to use yet, as I'm still working out some of the basic functionality. Feel free to check out the [GitHub Issues for this project](https://github.com/snipe/snipe-it/issues) to check on progress, open a bug report, or see what open issues you can help with.

-----

## Requirements

- PHP 5.3.7 or later
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

	git clone http://github.com/snipe/snipe-it your-folder

#### 1.2) Download the Repository

	https://github.com/snipe/snipe-it/archive/master.zip

-----

### 2) Install the Dependencies via Composer
##### 2.1) If you don't have composer installed globally

	cd your-folder
	curl -s http://getcomposer.org/installer | php
	php composer.phar install

##### 2.2) For globally composer installations

	cd your-folder
	composer install

-----

### 3) Setup Database

Copy the file `app/config/database.php` to `database.php`, and update `database.php` with your database name and credentials

	cp app/config/database.example.php app/config/database.php
    vi app/config/database.example.php

-----

### 4) Setup Mail Settings

Now, copy the file `app/config/mail.php` to `mail.php`, and update `mail.php` with your mail settings

	cp app/config/mail.example.php app/config/mail.php
    vi app/config/mail.example.php

This will be used to send emails to your users, when they register and they request a password reset.

-----

### 5) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install

-----

### 6) Fix permissions

You'll need to make sure that the app/storage directory is writable by your webserver, since caches and log files get written there. You should use the minimum permissions available for writing, based on how you've got your webserver configured.

	chmod -R 755 app/storage

If you still run into a permissions error, you may need to increase the permissions to 775, or twiddle your user/group permissions on your server.

	chmod -R 775 app/storage

-----

### 7) Set the correct document root for your server

The document root for the app should be set to the public directory. In a standard Apache virtualhost setup, that might look something like this:

	<VirtualHost *:80>
    DocumentRoot /var/www/html/public
    ServerName www.example.org

    # Other directives here
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

