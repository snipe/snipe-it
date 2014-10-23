# Common Issues

While installation should be pretty simple, here are some of the more common questions/issues people have.

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


