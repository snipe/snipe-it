---
currentMenu: requirements
---

# System Requirements

The requirements for Snipe-IT are fairly standard for a modern web server, and most servers will have most or all of these components already installed. If for some reason you don't have them installed, they are relatively easy to add.

## General System Requirements

- PHP 5.4 or later: [<i class="fa fa-linux"></i>](http://php.net/manual/en/install.unix.debian.php) [<i class="fa fa-windows"></i>](http://www.microsoft.com/web/gallery/install.aspx?appid=PHP54)
- PHP Extensions: MCrypt, Fileinfo, php-pdo, php-mysql, php-mbstring, php-curl
- MySQL or MariaDB
- SSH access to the server (if using Linux)
- GD Library (>=2.0) or Imagick PHP extension (>=6.3.8)
- php-ldap extension (only if using LDAP)

## <i class="fa fa-linux"></i> Requirements Specific to Linux/OSX
- Mod Rewrite

## <i class="fa fa-windows"></i> Requirements Specific to Windows Server

- IIS
- IIS URL Rewrite
- MariaDB 10.0.14 for Windows  [64-bit](https://downloads.mariadb.org/interstitial/mariadb-10.0.14/winx64-packages/mariadb-10.0.14-winx64.msi/from/http%3A//mirror.aarnet.edu.au/pub/MariaDB) | [32-bit](https://downloads.mariadb.org/interstitial/mariadb-10.0.14/win32-packages/mariadb-10.0.14-win32.msi/from/http%3A//mirror.aarnet.edu.au/pub/MariaDB)
- [PHP Manager for IIS](http://phpmanager.codeplex.com/) (makes managing PHP on IIS much easier)
- [Composer install with the shell menus](https://getcomposer.org/Composer-Setup.exe)
- [Notepad++](http://www.notepad-plus-plus.org/download/v6.6.6.html) for editing files
