---
currentMenu: subdirectory
---

# Installing Snipe-IT Into a Subdirectory

If you wish to run Snipe-IT in a subdirectory (`https://yourserver.com/snipe-it`) instead of at a primary domain (`http://yourserver.com`) or a sub-domain (`https://snipe-it.yourserver.com`), you'll need to go through the standard install steps 1-5, and then make a few  small changes to your server configuration and `.htaccess` file.

## Add an Alias Directive
In a standard Apache virtualhost setup, you'll need to add an `Alias` attribute to the virtualhost in your `httpd.conf`. That might look something like this, if your path to the Snipe-IT files were `/var/www/html/snipe-it/public`:

```
<VirtualHost *:80>

    Alias /snipe-it "/var/www/html/snipe-it/public"

	<Directory /var/www/html/snipe-it/public>
		Allow From All
		AllowOverride All
		Options +Indexes
	</Directory>

	DocumentRoot /var/www/html/snipe-it/public
	ServerName www.yourserver.com
	# Other directives here
</VirtualHost>
```

(Make sure to restart the webserver after making configuration changes to the Apache configs.)

## Modify Your .htaccess

You'll need to add one line to your `.htaccess` file to make this work. Immediately beneath the `RewriteEngine On`, add the option `RewriteBase /snipe-it`, once again assuming that your subdirectory URL is  `http://yourserver.com/snipe-it`.

 ```
 <IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On
    RewriteBase /snipe-it

    # Uncomment these two lines to force SSL redirect
    # RewriteCond %{HTTPS} off
	# RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```
