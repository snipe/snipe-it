---
currentMenu: windows
---

# <i class="fa fa-windows"></i> Install Snipe-IT Windows 2008 R2 With IIS

<div id="generated-toc"></div>


Prereq (Install all of these prior to continuing)

- IIS
- IIS URL Rewrite
- [PHP 5.4](http://www.microsoft.com/web/gallery/install.aspx?appid=PHP54)
- MariaDB 10.0.14 for Windows [64-bit](https://downloads.mariadb.org/interstitial/mariadb-10.0.14/winx64-packages/mariadb-10.0.14-winx64.msi/from/http%3A//mirror.aarnet.edu.au/pub/MariaDB) | [32-bit](https://downloads.mariadb.org/interstitial/mariadb-10.0.14/win32-packages/mariadb-10.0.14-win32.msi/from/http%3A//mirror.aarnet.edu.au/pub/MariaDB)
- [PHP Manager for IIS](http://phpmanager.codeplex.com/) (makes managing PHP on IIS much easier)
- [Composer install with the shell menus](https://getcomposer.org/Composer-Setup.exe )
- [Notepad++](http://www.notepad-plus-plus.org/download/v6.6.6.html ) for editing files

### Setting Up an IIS Website
- [Download Snipe-IT](http://snipeitapp.com/download.php)
- Extract to `C:\inetpub\wwwroot\snipe-it` (folder name can be changed but we will reference it as is shown here)
- Run IIS Manager
- Right Click `Sites` and `Add Website`

```
Site name: Snipe IT
Physical path: C:\inetpub\wwwroot\snipe-it\public
Binding
Type: http
IP address: All Unassigned or a specific IP if you have one you will be using
Port: 80 or any you wish to use
Host name: assets.portal.local (this can be changed to suit your needs)
```

- Click `OK`
Your site will now appear in the list
- Double click on your site
- Double Click `URL Rewrite`
    1. In the action pane click `Import Rules...`
    2. Click the `...` button
    3. Go to `C:\inetpub\wwwroot\snipe-it\public`
    4. Select `.htaccess` file
    5. Click `Open` then `Import`
    6. In the action pane click `Apply`



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
