---
currentMenu: importing-assets
---

# Importing Users and Assets

There is a basic asset import tool in later versions of Snipe-IT. It is available through the command-line only, as vry large file uploading and processing will cause memory exhaustion issues on many servers. We'll be working on a way to make this web-based and chunk data in the future.

### Usage:

```
php artisan import:csv path/to/your/file.csv --domain=yourdomain.com
```

The importer will be looking for a CSV in the format of:

```
Assigned To, Category, Asset Model Name, Manufacturer, Model Number,Serial Number, Asset Tag, Location
```

It will split the user's name, creating firstname and lastname, will generate an email address using your domain and the FirstInitialLastName@yourdomain.com pattern, will generate a password for them, and will create the asset models, locations, category, etc if they don't currently exist.

It currently does not do any validation other than checking to see if the record already exists in the database.

It determines if the user exists by looking up the email address (which has been generated as FirstInitialLastName@yourdomain.com, and may not be correct for all email naming conventions.)

When using this, __BACK UP YOUR DATABASE FIRST__. This is experimental, and it might cause unexpected results with your data. We have successfully used this cli tool to import a CSV of over 2,000 assets, but there's some data cleansing and checking that needs to be built in before it's bulletproof.
