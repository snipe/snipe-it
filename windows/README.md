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
	Update the file under the section `Detect The Application Environment`. SAME DETAILS AS README.MD
3. Copy `app/config/local/database.example.php` to `app/config/local/database.php`
    1. Open `app/config/local/database.php` in notepad++
    2. Update `database.php` with your database name and credentials

4. Copy `app/config/local/mail.example.php`  to `app/config/local/mail.php`.
4.1. Open `app/config/local/mail.php` in notepad++
4.2. Update `mail.php` with your mail settings

5. Copy `app/config/local/app.example.php` to `app/config/local/app.php`
    1. Open `app/config/local/app.php` in notepad++
    2. Update `app.php` with your URL settings

6. Open `C:\inetpub\wwwroot\snipe-it` in Windows Explorer
    1. Right Click and select `Composer Install`.
This will install the dependencies. Once completed move to next step
    2. Right Click and select `Use Composer here`
    3. Type `php artisan app:install` and follow the prompts
7. Add permissions for the IIS user for the `storage` folder:
    1. Goto `C:\inetpub\wwwroot\snipe-it\app`
    2. Right Click `Storage` -> `Properties`
    3. Goto `Security Tab` -> `Edit`
    4. Find `IIS_IUSRS` and set to `Full Control`
    5. Click `OK` twice

Special thanks to [@madd15](http://github.com/madd15) for writing up the Windows installation guide!
