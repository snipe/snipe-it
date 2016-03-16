---
currentMenu: user-management
---

# User Management

<div id="generated-toc" class="generate_from_h2"></div>

Snipe-IT comes with ability to manage users within the system.

## User Throttling / Unsuspending Users

If a user locks themselves out by attempting and failing to login too many times (default is 5 failed attempts), they will be locked out of the system for 15 minutes. If you need to unlock them before the 15 minutes is up, you can manually unsuspend them by going to the People section, searching for their name, and then clicking the unsuspend icon.

![Unsuspend](/img/unsuspend-user.png)

-----

##Permissions


| Ability       | Super User | Admin | Reporter | User |
| ------------- | -----------|-------|----------|------|
|Create Companies|Yes        |Yes    |No        |No    |
|Delete Companies|Yes        |Yes    |No        |No    |
|Create Asset Models|Yes     |Yes    |No        |No    |
|Delete Asset Models|Yes     |Yes    |No        |No    |
|Create Asset Categories|Yes |Yes    |No        |No    |
|Delete Asset Categories|Yes |Yes    |No        |No    |
|Create Manufacturer|Yes     |Yes    |No        |No    |
|Delete Manufacturer|Yes     |Yes    |No        |No    |
|Create Suppliers|Yes        |Yes    |No        |No    |
|Delete Suppliers|Yes        |Yes    |No        |No    |
|Create Status Labels|Yes    |Yes    |No        |No    |
|Delete Status Labels|Yes    |Yes    |No        |No    |
|Create Asset Depreciation|Yes|Yes   |No        |No    |
|Delete Asset Depreciation|Yes|Yes   |No        |No    |
|Create Locations|Yes        |Yes    |No        |No    |
|Delete Locations|Yes        |Yes    |No        |No    |
|Create Groups  |Yes         |Yes    |No        |No    |
|Delete Groups  |Yes         |Yes    |No        |No    |
|Take Backup    |Yes         |No     |No        |No    |
|Delete Backup  |Yes         |No     |No        |No    |
|Edit System Settings|Yes    |Yes    |No        |No    |
|Create Users   |Yes         |Yes    |No        |No    |
|Remove Users   |Yes         |No     |No        |No    |
|Create Assets  |Yes         |Yes    |No        |No    |
|Edit Super Users|Yes        |Yes    |No        |No    |
|Unlock Users   |Yes         |Yes    |No        |No    |
|Edit Users Permissions|Yes  |Yes    |No        |No    |
|View Items Assigned to User|Yes|Yes |No        |No    |
|Request Assets |No          |No     |No        |Yes   |
|Generate Reports| Yes       |Yes    |Yes       |No    |


-----

## Optional: LDAP Configuration

**Note: You must have the `php-ldap` extension installed for LDAP integration to work.**

To set up your Snipe-IT installation to be able to use LDAP for user login and import, go to `Admin > Settings` and scroll down to the LDAP settings sections.

If you don't have an LDAP server (or don't wish to import your users, or allow them to login using their LDAP credentials), you can skip this step.

The LDAP functionality will import any users in your LDAP/Active Directory, but will leave existing users untouched.

| Option  | Example | Notes | Required |
| ------------- | ------------- |
|LDAP Server|`ldap://ldap.example.com`|The URL of the LDAP server.| Yes|
|LDAP Bind Username|`cn=read-only-admin,dc=example,dc=com`|Username to use to connect authenticate to LDAP.| Yes |
|LDAP Bind Password|`password`|Password to use when authenticating to LDAP.| Yes|
|Base Bind DN|`dc=example,dc=com`|The base where the search for users will be executed.|Yes|
|LDAP Filter|`&(cn=*)`|The search filter for the LDAP query.| Yes|
|Username Field|`uid`|The name of the field in your LDAP that you want to use for Snipe-IT username. |Yes|
|Last Name|`sn`|The name of the field in your LDAP to use for last name. This is often `sn` (for surname)|Yes|
|LDAP First Name|`cn`|The name of the field in your LDAP to use for first name.|Yes|
|LDAP Authentication query|`uid="`|The LDAP query we should use to search your LDAP users. (This is usually `samaccountname=` in Active Directory, `uid="` in non-AD LDAP.)|Yes|
|LDAP Version|`3`|Version of LDAP. This is usually going to be `3`|Yes|
|LDAP Active Flag|`active`|Only necessary if you use a field in LDAP to indicate if the user is active. Can otherwise be left blank.|No|
|LDAP Employee Number| |Only necessary if you use a field in LDAP to store an employee number. Can otherwise be left blank.|No|
|LDAP Email|`mail`|LDAP field that should map to an email address for the user|Yes|

**Note: In most cases, all attribute values you enter should be all lowercase.**

Once your settings are entered, make sure you check the `LDAP Integration` checkbox to enable LDAP authentication.

### Example Settings

We use a public LDAP server by <a href="http://www.forumsys.com/tutorials/integration-how-to/ldap/online-ldap-test-server/">Forumsys</a> to test LDAP functionality. To test using this server, use the LDAP Server `ldap://ldap.forumsys.com`.
