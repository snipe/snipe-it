---
currentMenu: importing-assets
---

# Importing Users and Assets

<div id="generated-toc" class="generate_from_h2"></div>

Snipe it v3 brings with it a new importing tool that can import Assets, accessories, and consumables.

Make sure you have your organization's domain name filled out in the `domain` value in `app/config/production/app.php`, so that it knows what domain to use when generating email addresses if none are provided in your CSV.

## Usage:

```
php artisan snipeit:import path/to/your/file.csv --email_format=firstname.lastname --username_format=firstname.lastname```


| Option            | Values                                                                                    | Required |
|-------------------|-------------------------------------------------------------------------------------------|----------|
| `email_format`    | `firstname`, `firstname.lastname`, or `filastname` (for first initial, last name)         | No       |
| `username_format` | `firstname`, `firstname.lastname`, `filastname` (for first initial, last name) or `email` | No       |
| `testrun`         | None. This option just parses data without saving it to database.                         | No       |
| `item-type`       | `Asset`, `Accessory`, `Consumable` (defaults to Asset)                                    | No       |
| `logfile`         | Any valid path.  Defaults to `snipe-it-directory/storage/logs/importer.log`               | No       |

## CSV Format
The importer uses the first row of the CSV to determine what each column is.  The value in each cell must match the following table in order to be parsed.  This is not case sensative, and order does not matter.

```
Item Type, Name, Email, Username, Item Name, Category, Model Name, Manufacturer, Model Number, serial number, Asset Tag, Location, Notes, Purchase Date, Purchase Cost, Image, Status
```

 **There should not be any blank lines at the end of the CSV.**

[__Download a sample CSV with dummy data__](http://docs.snipeitapp.com/sample-assets.csv)
### Common Fields
| Field         | Example Data           | Required | Notes                                                                                                                                  |
|---------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------------------|
| Item Name     | `Karen 2015`           | No       |                                                                                                                                        |
| Company       | `MacandDonalds`        | Yes      | Created if it doesn't exist                                                                                                            |
| Category      | `Laptop`               | Yes      | Created if it doesn't exist                                                                                                            |
| Location      | `San Diego`            | Yes      | Created if it doesn't exist                                                                                                            |
| Purchase Date | `2015-01-12 07:30:30`  | No       | Can take any date format that can be translated by `strtotime()`                                                                       |
| Purchase Cost | `2999.99`              | No       | Cost of asset                                                                                                                          |
| 

### Asset Exclusive Fields
| Field         | Example Data           | Required | Notes                                                                                                                                  |
|---------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------------------|
| Name          | `Firstname Lastname`   | No       | No commas. First name first, last name last                                                                                            |
| Email         | `you@example.com`      | No       | If empty, will be generated using the `email_format` and `domain` you provide in your `app/config/production/app.php`                  |
| Username      | `yourname.lastname`    | No       | If empty, will be generated using the `username_format` you provide in the import command                                              |
| Model Name    | `MBP Retina 13-inch`   | Yes      | Created if it doesn't exist                                                                                                            |
| Manufacturer  | `Apple`                | Yes      | Created if it doesn't exist                                                                                                            |
| Model Number  | `MacbookPro12,1`       | No       |                                                                                                                                        |
| Serial Number | `C20095805496869045H6` | No       |                                                                                                                                        |
| Asset Tag     | `KJH90890`             | Yes      |                                                                                                                                        |
| Notes         | `Karens old machine`   | No       |                                                                                                                                        |
| Image         | `Filename.jpg`         | No       | If Present, this is the basename of the image assocaited with the item.  **Images must be manually uploaded to public/uploads/images** |
| Status        | `Working`              | No       | A status label applied to the item.  Created if it doesn't exist.                                                                      |
| Warranty      | `15`                   | No       | Time in months until warranty expires                                                                                                  |



### Accessory/Consumable Exclusive Fields
| Field         | Example Data           | Required | Notes                                                                                                                                  |
|---------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------------------|
| Quantity      | `15`                   | No       |  Amount of item in stock.  Defaults to 1.                                                                                              |

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
