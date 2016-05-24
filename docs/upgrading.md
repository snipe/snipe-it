---
currentMenu: upgrading
---

# Upgrading
Updating Snipe-IT should be pretty straightforward. Simply pull down the newest release, copy the files over, and run whatever commands the release notes specify. Your configuration files won’t be overwritten, since you had to copy them over from the example configs, and your version isn’t in version control.

You may want to backup the `app/config/app.php` file however, as that one file will be overwritten. If you forget to back it up, it's not usually a big deal, just go back in after upgrading and set your timezone back to the one you had before. 

__Always backup your database and configuration files before upgrading.__ We try very hard to make sure that all database changes are non-destructive, but you should always backup beforehand anyway. You will never regret backing up your database. You may regret not doing so, so it’s just better to get into the habit.

If you don’t plan on contributing code to Snipe-IT, you should always grab the latest stable release from the releases page, and avoid using the `develop` or `master` branches.

Whenever you pull down a new version from master or develop, or when you grab the latest official release, make sure to run the following commands via command line:

```
php composer.phar install --no-dev --prefer-source
php composer.phar dump-autoload
php artisan migrate
```

(Developers should remove the `--no-dev` flag, so they have unit test frameworks and debugging tools.)

Forgetting to run these commands can mean your DB might end up out of sync with the new files you just pulled, or you may have some funky cached autoloader values.

It’s a good idea to get into the habit of running these every time you pull anything new down. If there are no database changes to migrate, it won't hurt anything to run migrations anyway, you’ll just see "Nothing to migrate".

In some cases, it can help to delete the contents (just the contents, not the directories themselves) of `app/storage/cache` and `app/storage/views`.

If you have any issues upgrading, check the [common issues](common-issues.html) page for a fix. If you don’t see your issue listed there, open an issue on Github and we’ll try to get you sorted out. Be sure to provide the information outlined in the [Getting Help](getting-help.html) section of this site so that we have the info we need to assist you.

IMPORTANT: If you’re upgrading from `v.0.3.0-alpha` or earlier, make sure to update your hostname information in `bootstrap/start.php`, per the new requirements in Laravel 4.1.
