---
currentMenu: importing-assets
---

# Importing Users and Assets

<div id="generated-toc" class="generate_from_h2"></div>

Snipe it v3 brings with it a new importing tool that can import Assets, accessories, and consumables.<sup>*</sup>.

<sup>*</sup>This web-based importer should be limited to imports of 1000 records at a time or less. We're working on making it able to handle more records at a time.

Make sure you have your organization's domain name filled out in the `domain` value in `app/config/production/app.php`, so that it knows what domain to use when generating email addresses if none are provided in your CSV.

## Usage:

```
php artisan snipeit:import path/to/your/file.csv --email_format=firstname.lastname --username_format=firstname.lastname
```


| Option  | Values | Required |
| ------------- | ------------- |
|`email_format`|`firstname`, `firstname.lastname`, or `filastname` (for first initial, last name)| Yes |
|`username_format`|`firstname`, `firstname.lastname`, `filastname` (for first initial, last name) or `email`| Yes |


## CSV Format
The importer uses the first row of the CSV to determine what each column is.  The value in each cell must match the following table in order to be parsed.  This is not case sensative, and order does not matter.

```
Item Type, Name, Email, Username, Item Name, Category, Model Name, Manufacturer, Model Number, serial number, Asset Tag, Location, Notes, Purchase Date, Purchase Cost, Image, Status
```

 **There should not be any blank lines at the end of the CSV.**

[__Download a sample CSV with dummy data__](http://docs.snipeitapp.com/sample-assets.csv)

| Field   | Example Data | Required | Notes |
| ------------- | ------------- |
|Item Type|`Asset`| No | Valid options are `Asset`, `Accessory`, or `Consumable`.  If this field is blank, asset is assumed.|
|Name|`Firstname Lastname` | No| No commas. First name first, last name last |
|Email| `you@example.com`| No|If empty, will be generated using the `email_format` and `domain` you provide in your `app/config/production/app.php`|
|Username| `yourname.lastname`| No|If empty, will be generated using the `username_format` you provide in the import command|
|Item Name |`Karen 2015`| No |  |
|Category |`Laptop`| Yes | Created if it doesn't exist |
|Model Name | `MBP Retina 13-inch`| Yes |Created if it doesn't exist |
|Manufacturer| `Apple`|Yes | Created if it doesn't exist |
|Model Number| `MacbookPro12,1`| No |  |
|Serial Number | `C20095805496869045H6`| No |  |
|Asset Tag | `KJH90890`| Yes | |
|Location | `San Diego`| Yes | Created if it doesn't exist |
|Notes | `Karens old machine`| No | |
|Purchase Date | `2015-01-12 07:30:30`| No | Can take any date format that can be translated by `strtotime()`|
|Purchase Cost | `2999.99`| No | Cost of asset|
|Image         | 'Filename.jpg' | No | If Present, this is the basename of the image assocaited with the item.  **Images must be manually uploaded to public/uploads/images**|
|Status		   | `Working` | No | A status label applied to the item.  Created if it doesn't exist.

## What It Does

When you execute this command with a valid path to your CSV, the importer will:

- Split the user's name, creating `firstname` and `lastname`.
- If not user is provided, it assumes the asset is Ready to Deploy.
- If a user's name is provided, it assumes that asset is assigned to them
- If a user's name is provided but no email is provided, it will generate an email address using your domain and the pattern you specified in `email_format`
- Generate a password for the new user if a user's name is provided
- Create the user if they don't exist (based on their email address)
- Determine if the asset model exists based on Asset Model Name and Model Number combination
- Create the asset models, locations, category, etc if they don't currently exist, skip them if they do.
- If no user is provided, the asset gets created as ready to deploy instead of checked out to a user

When using this, __BACK UP YOUR DATABASE FIRST__. This is experimental, and it might cause unexpected results with your data. There's some data cleansing and checking that needs to be built in before it's bulletproof.

## Limitations & Notes

The importer isn't very smart. It currently does not do any validation other than checking to see if the record already exists in the database. It doesn't know that `Dell Inspiron` is the same asset as `Dell Insprion`. The quality of your data will make a big difference in the results you get, so if there's a lot of inconsistency, you're going to end up with with duplicates because the app has no way of knowing what you **meant** from what you wrote.
