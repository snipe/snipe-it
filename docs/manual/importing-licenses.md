---
currentMenu: importing-licenses
---

# Importing Users and Licenses

<div id="generated-toc" class="generate_from_h2"></div>

There is a license import tool in later versions of Snipe-IT ( > `1.2.10`). It is available through the command-line only, as very large file uploading and processing will cause memory exhaustion issues on many servers. We'll be working on a way to make this web-based and chunk data in the future.

## Usage:

```
php artisan license-import:csv path/to/your/file.csv --domain=yourdomain.com --email_format=firstname.lastname
```


| Option  | Values | Required |
| ------------- | ------------- |
|`domain`| a domain name string formatted as yourdomain.com| Yes|
|`email_format`|`firstname`, `firstname.lastname`, or `filastname` (for first initial, last name)| Yes |


## CSV Format
The importer will be looking for a CSV in the format of:

```
User Name, User Email, Username, Software Name, Serial, Licensed to Name, Licensed to Email, Seats, Reassignable, Supplier, Maintained, Notes, Purchase Date
```

The importer will ignore the first line of your CSV, so if you don't have a header row, you should add one.

[__Download a sample CSV with dummy data__](http://docs.snipeitapp.com/sample-licenses.csv)

| Field   | Example Data | Required | Notes |
| ------------- | ------------- |
|User Name|`Firstname Lastname` | No| No commas. First name first, last name last |
|User Email| `you@example.com`| No|If empty, will be generated using the `email_format` and `domain` you provide in the import command|
|Username| `agianotto`| No|This will be required in 2.0|
|Software Name| `Adobe Photoshop 5`|Yes|Name of the software|
|Serial|`8495867487HJGJ`|Yes|Serial number for the software|
|Licensed To Name|`Grokability, Inc`|No|Name the license was registered to, if applicable|
|Licensed To Email|`snipe@grokability.com`|No|Email the license was registered to, if applicable|
|Seats|`5`|Yes|Number of seats the license has, in numeric format|
|Reassignable|`Yes`|No|Whether the license can be reassigned|
|Supplier|`Acme, Inc`|No|Software supplier's name|
|Maintained|`Yes`|No|Whether the license is maintained by the supplier|
|Asset Notes | `Expensed to client XYZ`| No | |
|Purchase Date | `2015-01-12 07:30:30`| No | Can take any date format that can be translated by `strtotime()`|

## What It Does

When you execute this command with a valid path to your CSV, the importer will:

- Split the user's name, creating `firstname` and `lastname`.
- If not user is provided, it assumes the asset is Ready to Deploy.
- If a user's name is provided, it assumes that asset is assigned to them
- If a user's name is provided but no email is provided, it will generate an email address using your domain and the pattern you specified in `email_format`
- Generate a password for the new user if a user's name is provided
- Create the user if they don't exist (based on their email address)
- Determine if the supplier exists, create it if it doesn't
- Create the appropriate number of license seat records


When using this, __BACK UP YOUR DATABASE FIRST__. This is experimental, and it might cause unexpected results with your data. There's some data cleansing and checking that needs to be built in before it's bulletproof.

## Limitations & Notes

The importer isn't very smart. It currently does not do any validation other than checking to see if the record already exists in the database. It doesn't know that `Aobe Acrobat` is the same asset as `Adobe Acrobat`. The quality of your data will make a big difference in the results you get, so if there's a lot of inconsistency, you're going to end up with with duplicates because the app has no way of knowing what you **meant** from what you wrote.
