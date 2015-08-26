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
