---
currentMenu: importing-assets
---

# Importing Users and Assets

There is a basic asset import tool in later versions of Snipe-IT. It is available through the command-line only, as vry large file uploading and processing will cause memory exhaustion issues on many servers. We'll be working on a way to make this web-based and chunk data in the future.

### Usage:

```
php artisan import:csv path/to/your/file.csv --domain=yourdomain.com --email_format=firstname.lastname
```


| Option  | Values | Required |
| ------------- | ------------- |
|`domain`| a domain name string formatted as yourdomain.com| Yes|
|`email_format`|`firstname`, `firstname.lastname`, or `filastname` (for first initial, last name)| Yes |


The importer will be looking for a CSV in the format of:

```
Name, Email, Asset Category, Asset Model, Manufacturer, Asset Model Number, Asset Serial, Asset Tag, Location, Asset Notes
```

[__Download a sample CSV with dummy data__](http://snipeitapp.com/wp-content/uploads/2015/07/sample.csv)

When you execute this command with a valid path to your CSV, the importer will:

- Split the user's name, creating `firstname` and `lastname`,
- Generate an email address using your domain and the whatever pattern you specified in `email_format`
- Generate a password for them
- Create the user if they don't exist (based on their email address)
- Create the asset models, locations, category, etc if they don't currently exist, skip them if they do.

It currently does not do any validation other than checking to see if the record already exists in the database.

When using this, __BACK UP YOUR DATABASE FIRST__. This is experimental, and it might cause unexpected results with your data. We have successfully used this cli tool to import a CSV of over 2,000 assets, but there's some data cleansing and checking that needs to be built in before it's bulletproof.
