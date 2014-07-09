# Upgrading
### Important Notes on Updating

Whenever you pull down a new version from master or develop, when you grab the [latest official release](https://github.com/snipe/snipe-it/releases), make sure to run the following commands via command line:

	php composer.phar dump-autoload
	php artisan migrate

Forgetting to do this can mean your DB might end up out of sync with the new files you just pulled, or you may have some funky cached autoloader values. It's a good idea to get into the habit of running these every time you pull anything new down. If there are no database changes to migrate, it won't hurt anything to run migrations anyway.
