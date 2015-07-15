---
currentMenu: configuration
---

# Snipe-IT Configuration Files

<div id="generated-toc"></div>

## Adjust Environments

Update the file `bootstrap/start.php` under the section Detect The Application Environment.

To find out your local machine’s hostname, type hostname from a terminal prompt on the machine you’re installing it on. The command-line response is that machine’s hostname. Please note that the hostname is NOT always the same as the domain name.

So for example, if you’re installing this on your server named www.yourserver.com, the environmental variable section of bootstrap/start.php might look like this:


```php
$env = $app->detectEnvironment(array(
    ...
    'production'     => array('www.yourserver.com')
));
```

## Setup Your Database

__Note: You must create the database yourself. Snipe-IT does not create the database or database users for you.__

Copy the example database config from `app/config/production/database.example.php` to app/config/production/database.php. Update the file `app/config/production/database.php` with your database name and credentials:

```
'mysql'=> array(
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'database' => 'snipeit_laravel',
    'username' => 'travis',
    'password' => '',
    'charset'  => 'utf8',
    'collation'=> 'utf8_unicode_ci',
    'prefix'   => '',
),
```


## Setup Mail Settings

Copy the example mail config from app/config/production/mail.example.php to app/config/production/mail.php:

```
cp app/config/production/mail.example.php app/config/production/mail.php
```

Update the file `app/config/production/mail.php` with your mail settings.

This will be used to send emails to your users, when they register and when they request a password reset.

If you don’t have easy access to a mail server, we suggest signing up for Mandrill. Their free tier allows for 12k free sends a month.

## Adjust the Application Settings

Copy the example app config from app/config/production/app.example.php to app/config/production/app.php:


```
cp app/config/production/app.example.php app/config/production/app.php
```

Update the file `app/config/production/app.php` with your URL settings.


```
'url'=> 'http://www.yourserver.com',
```

You should also change your secret key here from `Change_this_key_or_snipe_will_get_ya` to a random 32 character string. If you prefer to have your key randomly generated, run the artisan key:generate command from the application root a little later in this process.

## Fix permissions

You’ll need to make sure that the app/storage directory is writable by your webserver, since caches and log files get written there. You should use the minimum permissions available for writing, based on how you’ve got your webserver configured. You also need to change permissions for your uploads directory for user avatars and model images.

```
chmod -R 755 app/storage
chmod -R 755 app/private_uploads
chmod -R 755 public/uploads
```

If you still run into a permissions error, you may need to increase the permissions to 775, or twiddle your user/group permissions on your server.

__Note: It should go without saying, but make sure the Snipe-IT project directory is not owned by root. Your webserver should be running as your webserver’s user (often apache, nobody, or www-data). But never, ever root. Ever.__
