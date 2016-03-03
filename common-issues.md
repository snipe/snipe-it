---
currentMenu: common-issues
---

# Common Issues

<div id="generated-toc" class="generate_from_h2"></div>

While installation should be pretty simple, here are some of the more common questions/issues people have.

-----

## The requested URL /auth/signin was not found on this server
Chances are that `mod_rewrite` is either not installed on your system, or has not been configured correctly for your virtualhost using AllowOverride.

__Troubleshooting:__
Add garbage text into the `public/.htaccess` file on your local install and hit the homepage again. If it bombs out (it should), then mod_rewrite is probably working. If it doesn't, it means your webserver isn't even looking for the .htaccess rules and you'll need to check your virtualhost config.

(Make sure to take the garbage out of the .htaccess file once you've gotten it sorted!)

-----

## PHP Warning: require(/var/www/html/snipeit/bootstrap/../vendor/autoload.php): failed to open stream: No such file or directory

When you see this error, it means that you either forgot to install or run composer, or you did and it failed somewhere and didn't complete, so the dependencies Snipe-IT needs were not installed. See the docs on <a href="installation/composer.html">installing and running composer</a>, and check for any errors composer might return when you attempt to run `composer install`.

Once your composer errors are resolved, you can <a href="installation/command-line.html">continue with the installation</a>.

-----

## Error message: mcrypt_encrypt(): Size of key is too large for this algorithm

In `app/config/production/app.php`, find the `key` on line 56.

You can run

```
php artisan key:generate
```

to auto-generate a 32-character key for you. Paste the generated key in as the value of `key` in your config (within single quotes):

```
'key' => '36VpJ9xE3WyPQu4GYgckF82hRh9AVjYM',
```

-----

## Error message: mcrypt_encrypt(): Key size not supported by this algorithm. Only keys of sizes 16, 24 or 32 supported.

In `app/config/production/app.php`, find the `key` on line 56.

You can run

```
php artisan key:generate
```

to auto-generate a 32-character key for you. Paste the generated key in as the value of `key` in your config (within single quotes):

```
'key' => '36VpJ9xE3WyPQu4GYgckF82hRh9AVjYM',
```

-----

## During install or running migrations - SQLSTATE[HY000]: General error: 1005 Can't create table 'snipeit.#sql-3626_1c6' (errno: 150)

This happens when your default table engine is set to MyISAM (which in general is weird. InnoDB has been the default table engine in MySQL for quite some time).  

If you see this error:

```
Illuminate\Database\QueryException]
SQLSTATE[HY000]: General error: 1005 Can't create table 'snipeit.#sql-3626_1c6' (errno: 150) (SQL: alter table users add constraint users_company
_id_foreign foreign key (company_id) references companies (id))

[PDOException]
SQLSTATE[HY000]: General error: 1005 Can't create table 'snipeit.#sql-3626_1c6' (errno: 150)
```

Try running:

```
ALTER TABLE companies ENGINE = InnoDB;
```

on your MySQL database and then re-run migrations.

-----

## Call to undefined function Controllers\Admin\ldap_connect()

The PHP LDAP extension is not installed on your server. While this extension is not required for all Snipe-IT installations, it must be installed if you wish to use any of the LDAP functionality.

-----


## White page with error: Error in exception handler.

Make sure you've changed the permissions on the `app/storage` directory and all of the directories within to be writable by the web server.

-----

## Database [] not configured

This happens when you think you're running the app in a different environment than your app thinks it's running in. The most common reason for this is you either forgot to edit `bootstrap/start.php` to include your hostname in whichever environment you want to run it as, or the hostname you entered there is incorrect.
Snipe-IT will always default to production if it can't figure out what mode to run in.

To find your hostname, type `hostname` in a terminal prompt and copy the output to whichever of the environments in `bootstrap/start.php` that you want to run it in. The app examines this array, and if it finds a hostname there that matches the actual hostname, that's the environment it will run in.

Alternatively, you can try just copying your config files over into `app/config/production` and just letting it default to production if you don't plan on doing any code development.

-----

## FatalErrorException. Syntax error, unexpected '[', expecting ')'

The version of PHP you're using is too old to run Snipe-IT, which [requires](requirements.html) PHP 5.4 or later.

After upgrading PHP, you should also delete the contents of the cached views in `app/storage/views` once you upgrade PHP, to resolve any cached issues.

-----

## Error message: Error Output: PHP Fatal error: Call to undefined method IlluminateFoundationApplication::registerCoreContainerAliases() in ../src/Illuminate/Foundation/start.php on line 106

Remove `bootstrap/compiled.php` and your vendors dir, and try running `php composer.phar update`.

-----

## Image Source not readable

This usually means that the temporary directory is not writable by the web server. Check the permissions section of the documentation for your server OS and make sure you've granted the user the ability to write to the temp directory.

-----

## While running composer: intervention/image dev-master requires ext-fileinfo * -> the requested PHP extension fileinfo is missing or not enabled on your system.

As the error states, your server is missing the `fileinfo` extension, which is one of the requirements for running Snipe-IT.

Windows users must include the bundled `php_fileinfo.dll `DLL file in `php.ini` to enable this extension. To enable Fileinfo, add or uncomment this line in your php.ini:

```
extension=php_fileinfo.dll
```

and restart the web server.

Linux users need to add or uncomment the following in their `php.ini`:

```
extension=fileinfo.so
```

and restart the web server.

-----

## During composer install, it's asking me for my Github credentials

This is an artifact of Github having a very low API rate limit for unauthenticated accounts. Make sure you're using the `--prefer-source` flag when doing your composer installs and updates.

-----

## Call to undefined method IlluminateCookieCookieJar::get()

If you're using Snipe-IT 1.2.6 or earlier, grab the latest off of the develop branch and run `php composer install`, or edit your composer.json to use Sentry 2.1.* and then run `php composer update`.

-----

## PHP Fatal error: Class 'Patchwork\Utf8\Bootup' not found in \bootstrap\autoload.php on line 43

This happens sometimes with composer, though we don't really know why, as it's not specific to Snipe-IT. If you run into this error after running `php composer.phar install --no-dev --prefer-source`, try the following:

- delete your `composer.lock` file
- run `php composer.phar dump-autoload`
- run `php composer.phar update --no-dev --prefer-source`
