# Windows IIS
## Install Snipe-IT Windows 2008 R2 With IIS

Prereq (Install all of these prior to continuing)
* IIS
* IIS URL Rewrite
* [PHP 5.3 for Windows Server via WPM](http://www.microsoft.com/web/platform/phponwindows.aspx)
* [MariaDB 5.5 for Windows Server 64-bit](https://downloads.mariadb.org/interstitial/mariadb-5.5.37/winx64-packages/mariadb-5.5.37-winx64.msi/from/http://mirror.jmu.edu/pub/mariadb) | [32-bit](https://downloads.mariadb.org/interstitial/mariadb-5.5.37/win32-packages/mariadb-5.5.37-win32.msi/from/http://mirror.jmu.edu/pub/mariadb)
* [PHP Manager for IIS](http://phpmanager.codeplex.com/) (makes managing PHP on IIS much easier)
* [Composer install with the shell menus](https://getcomposer.org/Composer-Setup.exe )
* [Notepad++](http://www.notepad-plus-plus.org/download/v6.6.6.html ) for editing files

### Setting Up an IIS Website
1. [Download Snipe-IT](http://snipeitapp.com/download.php)
2. Extract to `C:\inetpub\wwwroot\snipe-it` (folder name can be changed but we will reference it as is shown here)
3. Run IIS Manager
4. Right Click `Sites` and `Add Website`

	```
	Site name: Snipe IT
	Physical path: C:\inetpub\wwwroot\snipe-it\public
	Binding
	Type: http
	IP address: All Unassigned or a specific IP if you have one you will be using
	Port: 80 or any you wish to use
	Host name: assets.portal.local (this can be changed to suit your needs)
	```

5. Click `OK`
Your site will now appear in the list
6. Double click on your site
7. Double Click `URL Rewrite`
    1. In the action pane click `Import Rules...`
    2. Click the `...` button
    3. Go to `C:\inetpub\wwwroot\snipe-it\public`
    4. Select `.htaccess` file
    5. Click `Open` then `Import`
    6. In the action pane click `Apply`


### Configuring Snipe IT
1. Open Windows Explorer and goto `C:\inetpub\wwwroot\snipe-it`
2. Open `bootstrap/start.php` with notepad++
   Update the file `bootstrap/start.php` under the section `Detect The Application Environment`.

	__AS OF LARAVEL 4.1__
	Per the [Laravel 4.1 upgrade docs](http://laravel.com/docs/upgrade):

	__*"For security reasons, URL domains may no longer be used to detect your application environment. These values 	are easily spoofable and allow attackers to modify the environment for a request. You should convert your 		environment detection to use machine host names (hostname command on Mac & Ubuntu)."*__

	To find out your local machine's hostname, type `hostname` from a terminal prompt on the machine you're 		installing it on. The command-line response is that machine's hostname. Please note that the hostname is NOT 		always the same as the domain name.

	So for example, if you're installing this on your server named www.yourserver.com, the environmental variable 		section of `bootstrap/start.php` might look like this:

		$env = $app->detectEnvironment(array(
			...
			'production' 	=> array('www.yourserver.com')
		));

	If your development, staging and production sites all run on the same server (which is generally a terrible idea), [see this example](http://words.weareloring.com/development/setting-up-multiple-environments-in-laravel-4-1/) of how to configure the app using environmental variables.


3. Copy `app/config/local/database.example.php` to `app/config/local/database.php`
    1. Open `app/config/local/database.php` in notepad++
    2. Update `database.php` with your database name and credentials

		```
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

4. Copy `app/config/local/mail.example.php`  to `app/config/local/mail.php`.
	1. Open `app/config/local/mail.php` in notepad++
	2. Update `mail.php` with your mail settings

5. Copy `app/config/local/app.example.php` to `app/config/local/app.php`
    1. Open `app/config/local/app.php` in notepad++
    2. Update the file `app/config/production/app.php` with your URL settings.

	```
	'url' => 'http://www.yourserver.com',
	```

	You should also change your secret key here -- if you prefer to have your key randomly generated, run the artisan key:generate command from the application root.


		php artisan key:generate --env=production


6. Open `C:\inetpub\wwwroot\snipe-it` in Windows Explorer
    1. Right Click and select `Composer Install`.
This will install the dependencies. Once completed move to next step
    2. Right Click and select `Use Composer here`
    3. Type `php artisan app:install` and follow the prompts
7. Add permissions for the IIS user for the `storage` folder:
    1. Goto `C:\inetpub\wwwroot\snipe-it\app`
    2. Right Click `storage` -> `Properties`
    3. Goto `Security Tab` -> `Edit`
    4. Click `Add` and change location to local machine
    5. Type `IUSR` in object name box
    6. Click `OK`
    7. Give `IUSR` full control
    8. Click `OK` twice
8. Add permissions for the IIS user for the `uploads` folder:
    1. Goto `C:\inetpub\wwwroot\snipe-it\app`
    2. Right Click `uploads` -> `Properties`
    3. Goto `Security Tab` -> `Edit`
    4. Click `Add` and change location to local machine
    5. Type `IUSR` in object name box
    6. Click `OK`
    7. Give `IUSR` full control
    8. Click `OK` twice
    
Special thanks to [@madd15](http://github.com/madd15) for writing up the Windows installation guide!
