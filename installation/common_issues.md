# Common Issues

While installation should be pretty simple, here are some of the more common questions/issues people have.

- 404 File Not Found on Sub-Pages
- Error message: mcrypt_encrypt(): Size of key is too large for this algorithm
- Call to undefined method Illuminate\Foundation\Application::registerCoreContainerAliases() in /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/start.php on line 106
- Symfony \ Component \ Debug \ Exception \ FatalErrorException. syntax error, unexpected '[', expecting ')'

### 404 File Not Found on Sub-Pages
If you can get to the index page without a problem, but you get a 404 on any of other pages, chances are that `mod_rewrite` is either not installed on your system, or has not been [configured correctly](http://askubuntu.com/questions/423514/how-to-enable-mod-rewrite-for-virtual-host) for your virtualhost using `AllowOverride`.

__Troubleshooting:__

Add garbage text into the `public/.htaccess` file on your local install and hit the homepage again. If it bombs out (it should), then `mod_rewrite` is probably working. If it doesn't, it means your webserver isn't even looking for the `.htaccess` rules and you'll need to check your virtualhost config.

(Make sure to take the garbage out of the `.htaccess` file once you've gotten it sorted!)

### Error message: mcrypt_encrypt(): Size of key is too large for this algorithm

In `app/<environment>/config/app.php`, find the key on line 43. Manually change that to a random string that is no more than 32 characters.

You can also run

    php artisan key:generate

to auto-generate a key for you.

Remember that if you're running this as anything other than `production`, you should append the environment name to the command so that it updates the correct `app.php`. For example:

    php artisan key:generate --env=local


### Error message: Error Output: PHP Fatal error:  Call to undefined method Illuminate\Foundation\Application::registerCoreContainerAliases()  in /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/start.php on line 106

Remove `bootstrap/compiled.php` and your vendors dir, and try re-running `php composer.phar update`.


### Symfony \ Component \ Debug \ Exception \ FatalErrorException. syntax error, unexpected '[', expecting ')'

This error occurs when you're using an older version of PHP and trying to run Snipe-IT.

Per the [PHP manual](http://php.net/manual/en/language.types.array.php):
> As of PHP 5.4 you can also use the short array syntax,
> which replaces array() with [].

PHP 5.4 is the minimum requirement in Snipe-IT, so you must upgrade your version of PHP to resolve this error.

You should also delete the contents of the cached views in `app/storage/views` once you upgrade PHP, to resolve any cached issues.
