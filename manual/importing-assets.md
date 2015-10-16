---
currentMenu: importing-assets
---

# Importing Users and Assets

<div id="generated-toc" class="generate_from_h2"></div>

There is an asset import tool in later versions of Snipe-IT ( > `1.2.8`). It is available through the command-line only, as very large file uploading and processing will cause memory exhaustion issues on many servers<sup>*</sup>.

<sup>*</sup>There is a beta web-based file-upload and import tool currently on the develop branch and slated for the next release. You'll find a `sample.csv` already in the import page which you can try out.


## Usage:

```
php artisan asset-import:csv path/to/your/file.csv --domain=yourdomain.com --email_format=firstname.lastname --username_format=firstname.lastname
```


| Option  | Values | Required |
| ------------- | ------------- |
|`domain`| a domain name string formatted as yourdomain.com| Yes|
|`email_format`|`firstname`, `firstname.lastname`, or `filastname` (for first initial, last name)| Yes |
|`username_format`|`firstname`, `firstname.lastname`, `filastname` (for first initial, last name) or `email`| Yes |


## CSV Format
The importer will be looking for a CSV in the format of:

```
Name, Email, Username, Asset Category, Asset Model, Manufacturer, Asset Model Number, Asset Serial, Asset Tag, Location Name, Asset Notes, Purchase Date, Purchase Cost
```

The importer will ignore the first line of your CSV, so if you don't have a header row, you should add one.

[__Download a sample CSV with dummy data__](http://docs.snipeitapp.com/sample-assets.csv)

| Field   | Example Data | Required | Notes |
| ------------- | ------------- |
|Name|`Firstname Lastname` | No| No commas. First name first, last name last |
|Email| `you@example.com`| No|If empty, will be generated using the `email_format` and `domain` you provide in the import command|
|Username| `yourname.lastname`| No|If empty, will be generated using the `username_format` you provide in the import command|
|Asset Category |`Laptop`| Yes | Created if it doesn't exist |
|Asset Model |`MBP Retina 13-inch`| Yes |Created if it doesn't exist |
|Manufacturer Name| `Apple`|Yes | Created if it doesn't exist |
|Asset Model No.| `MacbookPro12,1`| No |  |
|Asset Serial | `C20095805496869045H6`| Yes |  |
|Asset Tag | `KJH90890`| Yes | |
|Location Name | `San Diego`| Yes | Created if it doesn't exist |
|Asset Notes | `Karens old machine`| No | |
|Purchase Date | `2015-01-12 07:30:30`| No | Can take any date format that can be translated by `strtotime()`|
|Purchase Cost | `2999.99`| No | Cost of asset|

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
