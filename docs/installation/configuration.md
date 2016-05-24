---
currentMenu: configuration
---

# Snipe-IT Configuration Files

<div id="generated-toc" class="generate_from_h2"></div>

## Set Your Environment

Update the file `bootstrap/start.php` under the section Detect The Application Environment to include your server's hostname in the `production` array. This configuration option tells Snipe-IT whether it should run in development mode (local), staging, or production mode. __Unless you are a PHP developer setting up a local installation so that you can contribute code towards Snipe-IT, you should be running Snipe-IT in production mode__.

To find out your local machine’s hostname, type `hostname` from a terminal prompt on the machine you’re installing it on. The command-line response is that machine’s hostname. __Please note that the hostname is usually NOT the same as the domain name__.

So for example, if you’re installing this on your server named `CentOS-ip-9875`, the environmental variable section of `bootstrap/start.php` might look like this:


```php
$env = $app->detectEnvironment(array(
    ...
    'production'     => array('CentOS-ip-9875')
));
```
-----

## Set Timezone and Language Preferences

Open up `app/config/app.php` and edit the `timezone` and `language` settings to reflect your desired timezone and language. The default timezone is UTC. The timezone you use should be formatted as [an accepted PHP timezone](http://php.net/manual/en/timezones.php), so for example, for Pacific Time, you could use `America/Los_Angeles`:

```
'timezone' => 'America/Los_Angeles',
```

The default language is US English, however we have additional language translations available, thanks to a great community of people [helping us translate Snipe-IT](../translations.html).

```
'locale' => 'en',
```

If you wish to use one of the other available languages, simply replace the default value of `locale` from `en` to one of the values listed below.

| Language  | Value |
| ------------- | ------------- |
|Arabic|`ar`|
|Chinese Simplified|`zh-CN`|
|Czech|`cs`|
|Danish|`nl`|
|Dutch|`nl`|
|English|`en`|
|English, UK |`en-GB`|
|Finnish|`fi`|
|French|`fr`|
|German|`de`|
|Hungarian|`hu`|
|Italian|`it`|
|Japanese|`ja`|
|Korean|`ko`|
|Malay|`ms`|
|Norwegian|`no`|
|Polish|`pl`|
|Portuguese|`pr-PT`|
|Portuguese, Brazilian|`pr-BR`|
|Romanian|`ro`|
|Russian|`ru`|
|Spanish|`es-ES`|
|Swedish|`sv-SE`|
|Thai|`th`|
|Turkish|`tr`|
|Vietnamese|`vi`|

If you're interested in additional languages, or would like to help us translate some of the incomplete existing languages, please see the [Translations](../translations.html) page.

-----

## Edit Database Settings

__Note: You must create the database yourself. Snipe-IT does not create the database or database users for you.__

Copy the example database config from `app/config/production/database.example.php` to `app/config/production/database.php`. Update the file `app/config/production/database.php` with your database name and credentials, replacing `snipeit_laravel` with your database name, `travis` with your database username, and so on:

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

You can generally leave `charset`, `collation` and `prefix` as they are.

You do not need to run migrations or worry about the database schema during the installation. The [command-line installer](/installation/command-line.html) will create the initial database tables for you. 

-----

## Edit Mail Settings

Copy the example mail config from `app/config/production/mail.example.php` to `app/config/production/mail.php`, and update the new `app/config/production/mail.php` file with your settings for SMTP server, email username and password.

These settings will be used to send emails to your users, when they register and when they request a password reset.

While your mail settings will vary depending on how you've set up your server, the one line you must change regardless of your configuration is:

```
'from' => array('address' => null, 'name' => null),
```

__Make sure as you edit this section that you change the **values**, not the **keys**.__ For example,

```
'from' => array('address' => 'me@example.com', 'name' => 'John Smith'),
```

is __correct__, while

```
'from' => array('me@example.com' => null, 'John Smith' => null),
```

is __incorrect__ and will cause errors when it tries to send email.


Make sure you enclose your values in single quotes. For example,

```
'username' => 'myusername',
```

is __correct__, while

```
'username' => myusername,
```

is __incorrect__ and will cause errors when it tries to send email.

If you don't have an SMTP server to use, you can set the `driver` value to `mail`:

```
'driver' => 'mail',
```

### GoDaddy Email

If you're using GoDaddy for hosting, you will need to set your mail server to use `relay-hosting.secureserver.net` on port `25`, with `username` and `password` left as null values. See the [GoDaddy relay server documentation](https://www.godaddy.com/help/what-is-the-name-of-my-hosting-accounts-relay-server-953) for more specifics.

### Using Gmail

If you're using Gmail to send your emails, you'll want to use the settings below (in addition to filling out the from address and name in the config file):


| Setting       | Value |
| ------------- | -----------|
|`driver`|`'smtp'` |
|`host`|`'smtp.gmail.com''` |
|`port`|`587` |
|`encryption`|`'tls'` |
|`username`|`'your_gmail_username'` |
|`password`|`'your_gmail_password'` |

Additionally, you may need to tweak a few settings in your Gmail account to handle Google's security that can kick in if Google doesn't recognize the system you're trying to access it through.

- Sign into the Gmail account in a browser
- Go [here](https://www.google.com/settings/security/lesssecureapps) and enable access for "less secure" apps:
- Then go [here](https://accounts.google.com/b/0/DisplayUnlockCaptcha) and click Continue.
- If you're still getting errors, try [this solution on StackOverflow](http://stackoverflow.com/a/26041277/200021).

(More info on sending email through Laravel and Gmail is [available here](http://code.tutsplus.com/tutorials/sending-emails-with-laravel-4-gmail--net-36105), and more info on why Google makes you jump through these hoops is [available here](https://googleonlinesecurity.blogspot.co.uk/2014/04/new-security-measures-will-affect-older.html).)

### If you're still having problems

If you don’t have easy access to a mail server (or you can't get your settings to work for some reason), we suggest signing up for [Mandrill](http://mandrillapp.com). Their free tier allows for 12k free sends a month, which should more than cover normal Snipe-IT email usage.

-----

## Application Settings

Copy the example app config from `app/config/production/app.example.php` to `app/config/production/app.php`, and then update your new `app/config/production/app.php` with your URL settings.


```
'url'=> 'http://www.yourserver.com',
```

**This value should begin with the protocol (http:// or https://), as reflected in the example above.**

You should also change your secret key here from `Change_this_key_or_snipe_will_get_ya` to a random 32 character string. If you prefer to have your key randomly generated, run the `php artisan key:generate` command from the application root a little later in this process.

-----

## Set Directory Permissions

You’ll need to make sure that the `app/storage` directory and its subdirectories are writable by your web server, since caches and log files get written there. You should use the minimum permissions available for writing, based on how you’ve got your web server configured. You also need to change permissions for your `uploads` directory for user avatars and model images.

First, you'll need to figure out which user your webserver is running under. On Linux/OS X systems, it's usually something like "nobody", "apache", "httpd", "www", or "\_www" Determine that by using `ps auxwww` - then you can see who the server is running as.

Once you've determined your webserver's user, you will want to make sure your webserver has ownership of the appropriate directories:

```sh
chown -R that_username app/storage app/private_uploads public/uploads
```

Next, you'll want to ensure that this user has write permissions to those directories.

On Linux/OS X, you would do something like this:

```
chmod -R 755 app/storage
chmod -R 755 app/private_uploads
chmod -R 755 public/uploads
```
For help fixing permissions on IIS, see the [Windows Installation guide](server/windows.html).

If you still run into a permissions error, you may need to increase the permissions to 775, or twiddle your user/group permissions on your server so that the web server itself (Apache, IIS, etc) can write to files owned by the Snipe-IT user.

__Note: It should go without saying, but make sure the Snipe-IT project directory is not owned by root. Your webserver should be running as your webserver’s user (often apache, nobody, or www-data). But never, ever root. Ever.__

-----

## Optional: Set Cookies to HTTPS-only
As an extra security feature, Snipe-IT allows you to set your cookies to HTTPS-only, which will ensure that session cookies will only be sent back to the server if the browser has a HTTPS connection.

If you are running Snipe-IT over SSL and wish to use this feature, copy the example session config from `app/config/production/session.example.php` to `app/config/production/session.php`, and then update your new `app/config/production/session.php` file to reflect:

```
'secure' => true,
```

If you have this option set to `true` in your session config, your users will not be able to login if they access Snipe-IT over the non-HTTPS connection.

**Note: If you are NOT running Snipe-IT over SSL and you enable this option, your users will not be able to login. Only use this option if you are running Snipe-IT over SSL.**

-----

## Optional: Set Your .htaccess to Redirect to SSL

If you are running Snipe-IT over HTTPS and wish to automatically redirect the user to the HTTPS version if they accidentally go to the HTTP version, uncomment the following lines from the `public/.htaccess` file:

```
RewriteCond %{HTTPS} off
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

**Note: If you are NOT running Snipe-IT over SSL and you enable this option, your users will not be able to access the site. Only use this option if you are running Snipe-IT over SSL.**
