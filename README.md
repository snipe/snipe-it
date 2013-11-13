## Snipe-IT - Asset Management For the Rest of Us

This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, etc.

It is built on [Laravel 4](http://laravel.com) and uses the [Sentry 2](https://github.com/cartalyst/sentry) package. I chose Laravel because it's no better or worse than any other PHP framework out there, and not really for any other reason.

Many thanks to the [Laravel 4 starter site](https://github.com/brunogaspar/laravel4-starter-kit) for a quick start. 

This isn't actually ready for anyone to use yet, as I'm still working out some of the basic functionality. But stay tuned.

-----

## Requirements

- PHP 5.3.7 or later
- MCrypt PHP Extension

-----

## How to Install (Don't do this yet - it's not ready for you)

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

Now that you have the Starter Kit cloned and all the dependencies installed, you need to create a database and update the file `app/config/database.php`.

-----

### 4) Setup Mail Settings

Now, you need to setup your mail settings by just opening and updating the following file `app/config/mail.php`.

This will be used to send emails to your users, when they register and they request a password reset.

-----

### 5) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install
