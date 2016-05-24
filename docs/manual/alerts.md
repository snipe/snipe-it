---
currentMenu: alerts
---

# Configuring Email Alerts in Snipe-IT

To set up the cron to run every day, set up your crontab as:

```
@daily /path/to/php /path/to/your/snipe-it/artisan alerts:expiring
```

To set it to run every week, use:

```
@weekly /path/to/php /path/to/your/snipe-it/artisan alerts:expiring
```
