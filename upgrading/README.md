# Upgrading
### Important Notes on Updating

Whenever you pull down a new version from master or develop, when you grab the [latest official release](https://github.com/snipe/snipe-it/releases), make sure to run the following commands via command line:

	php composer.phar dump-autoload
	php artisan migrate

Forgetting to do this can mean your DB might end up out of sync with the new files you just pulled, or you may have some funky cached autoloader values. It's a good idea to get into the habit of running these every time you pull anything new down. If there are no database changes to migrate, it won't hurt anything to run migrations anyway.

__IMPORTANT: If you're upgrading from v.0.3.0-alpha or earlier, make sure to update your hostname information in `bootstrap/start.php`, per the [new requirements in Laravel 4.1](https://github.com/snipe/snipe-it#21-adjust-environments)__.

If you run into a weird error like

	Error Output: PHP Fatal error:  Call to undefined method Illuminate\Foundation\Application::registerCoreContainerAliases() in /var/www/
	html/vendor/laravel/framework/src/Illuminate/Foundation/start.php on line 106

Then try removing `bootstrap/compiled.php` and your vendors dir, and re-running `php composer.phar update`.
