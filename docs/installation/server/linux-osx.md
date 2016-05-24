---
currentMenu: linux-osx
---

# <i class="fa fa-linux"></i> Installing Snipe-IT on Linux/OSX

<div id="generated-toc" class="generate_from_h2"></div>


## Using Apache

The most common setup for Snipe-IT on a linux server is to use Apache, so if you're not sure what to pick, Apache might be the best bet, as it's free, easy to configure, and well documented.

__The `DocumentRoot` for the app should be set to the `public` directory.__

In a standard Apache virtualhost setup, that might look something like this:

```
<VirtualHost *:80>
	<Directory /var/www/html/public>
		Allow From All
		AllowOverride All
		Options +Indexes
	</Directory>

	DocumentRoot /var/www/html/public
	ServerName www.yourserver.com
	# Other directives here
</VirtualHost>
```

**Note**: `/var/www/html/public` is a common path used on web servers, however you will want to change `/var/www/html/public` to wherever the `public` directory is in within the Snipe-IT files on your server. If you are using the installer script for Centos6+/Ubuntu 14+ remember to change your `Directory` and `DocumentRoot` to `/var/www/html/snipeit/public`.

An OS X virtualhost setup could look more like:

```
<Directory "/Users/youruser/Sites/snipe-it/public/">
	Allow From All
	AllowOverride All
	Options +Indexes
</Directory>

<VirtualHost *:80>
	ServerName "www.yourserver.com"
	DocumentRoot "/Users/youruser/Sites/snipe-it/public"
</VirtualHost>
```

Snipe-IT requires `mod_rewrite` to be installed and enabled on systems running Apache. For more information on how to set up `mod_rewrite`, [click here](http://xmodulo.com/2013/01/how-to-enable-mod_rewrite-in-apache2-on-debian-ubuntu.html).

__Note that in Apache 2.4, you may need to use `Require all granted` instead of `Allow From All`.__

-----

## Using Nginx and PHP-FPM

If you wish to use Nginx and PHP-FPM instead of Apache, PHP-FPM will need to be installed and setup to listen on a socket.  For more information on how to setup PHP-FPM, [click here](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-12-04#step-five—configure-php).

```
server {
    listen 80;
    server_name localhost;

    root /Users/youruser/Sites/snipe-it/public/;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri $uri/ =404;
        fastcgi_pass unix:/var/run/php5-fpm-www.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

If you prefer to use a forced SSL setup, you can use the following configuration instead.

```
server {
    listen 80;
    server_name localhost;

    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl;
    server_name localhost;

    ssl_certificate /path/to/your.crt;
    ssl_certificate_key /path/to/your.key;
    ssl_protocols SSLv3 TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-RC4-SHA:ECDHE-RSA-AES256-SHA:DHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA:RC4-SHA:!aNULL:!eNULL:!EXPORT:!DES:!3DES:!MD5:!DSS:!PKS;
    ssl_session_timeout 5m;
    ssl_session_cache builtin:1000 shared:SSL:10m;

    root /Users/youruser/Sites/snipe-it/public/;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri $uri/ =404;
        fastcgi_pass unix:/var/run/php5-fpm-www.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Note that with the SSL configuration you will need to adjust the path to your SSL certificate or it will not work.  You can use a proper certificate generated from a CA or a self-signed certificate.  For more information on creating a self-signed certificate, [click here](https://www.digitalocean.com/community/tutorials/how-to-create-a-ssl-certificate-on-nginx-for-ubuntu-12-04).

-----

## Running this on an EC2 Micro Instance

Depending on your needs, you could probably run this system in an EC2 micro instance. It doesn't take up very much memory and typically won't be a super-high-traffic application. EC2 micros fall into the free/dirt-cheap tier, which might make this a nice option. One thing to note though - composer can be a little memory-intensive while you're running updates, and you may have trouble with it failing on a micro. You can crank the memory_limit up in php.ini, but EC2 micros have swap disabled by default, so even that may not cut it. If you run into totally unhelpful error messages while running composer updates (like simply 'Killed') or fatal memory issues mentioning phar, your best bet will be to enable swap:

	sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
	sudo /sbin/mkswap /var/swap.1
	sudo /sbin/swapon /var/swap.1

If you need more than 1024MB then change that to something higher.

To enable it by default after reboot, add this line to /etc/fstab:

	/var/swap.1 swap swap defaults 0 0


-----

## Notes on SELinux

If you’re running SELinux, you’ll need to change the security context in order for the web server to be able to write to files where needed (log files, image uploads, sessions, etc).

If you’re not sure, don’t worry about it unless you’ve set up Snipe-IT and you’re hitting permission errors even after you’ve updated the directory permissions to be writable.

To tell if you’re running SELinux, you can run:

```
cat /etc/sysconfig/selinux
```
or

```
sestatus
```

If it turns out you’re running SELinux, the syntax for changing the security context on a directory is:

```
chcon -type <type> <file>
chcon --reference <file1> <file2>
```

So for example, you might do something like:

```
chcon -R --type httpd_sys_rw_content_t /srv/snipeit
chcon -R --reference=/var/www/html /srv/snipeit
```

Depending on where your Snipe-IT files are located.
