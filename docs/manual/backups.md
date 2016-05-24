---
currentMenu: backups
---

# Automated Backups

In `v2.0` and later, Snipe-IT can automatically create a zipped backup of your database dump and any files you've uploaded. You can run this command manually by entering:

```
php artisan snipeit:backup
```


To set up the cron to run every day, set up your crontab as:

```
@daily /path/to/php /path/to/your/snipe-it/artisan snipeit:backup
```

To set it to run every week, use:

```
@weekly /path/to/php /path/to/your/snipe-it/artisan snipeit:backup
```

You will need to make sure that mysqldump is installed and set in your path. If mysqldump isn't in your path, you can set it manually by copying `/app/config/packages/schickling/backup/config.example.php` to `/app/config/packages/schickling/backup/config.php` and updating the mysqldump path information. 
