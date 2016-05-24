---
currentMenu: manually-editing-data
---

# Manually Editing Data in the Database

The short version:

## Don't.

If you start deleting records from tables manually, you will almost assuredly mangle your data in a way that will cause real problems. This software uses a relational database system, which means that some tables exist just to establish relationships between other pieces of data. When you delete part of that equation, Bad Things Happen&#0153;.

We utilize soft deletes in Snipe-IT, which means records are never really deleted, they are simply marked as deleted. This is by design, so that you don't lose history on an asset when, for example, you delete a user. Just because the user is no longer at your organization, that doesn't mean you would want to wipe the previous history of the assets they had while they were there.

## If you decide to do it anyway

**ALWAYS back up your database before you start manually editing database records**, so that when it breaks everything (and it probably will), you will be able to restore it.

If you absolutely insist on deleting data directly, make sure the corresponding records in the `asset_logs` table are also deleted. The `asset_logs` table holds all of the history for assets, accessories and users, and if you delete the assets, accessories, or users it ties together, things break.

If all else fails, delete the contents of `asset_logs`. This should be considered an absolute last resort, as you will be wiping out the history of every checkin, checkout and file upload in the history of the app. 
