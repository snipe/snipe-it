---
currentMenu: custom-fields
---

# Custom Fields and Fieldsets

Custom fields and fieldsets are available in Snipe-IT versions `2.1.0-pre` and later.

Custom fields allow you to track additional information about your assets that the default asset attributes don't cover.

Think of custom fieldsets as collections of custom fields. You can have a custom fieldset with just one custom field in it, or multiple custom fields. The idea of fieldsets is to keep commonly used fields grouped together so you don't have to add fields one-by-one to asset models.

Custom fieldsets are assigned at the asset model level. So, for example, if you track mobile phones as Assets, you could create custom fields for "IMEI", "SIM", "Phone Number", etc.

![Create mobile phones fieldset](/img/sim.png)

You would then add all of those mobile phone related fields to a new "Mobile Phones" custom fieldset, and assign it to one of your mobile phone asset models.

![Create mobile phones fieldset](/img/mobile-phones.png)

When you're adding a field to a fieldset, you can select whether that field should be required, what order it should appear in, and then select the fieldset to add from the select box.

![Create mobile phones fieldset](/img/add-to-fieldset.png)

Then, for any mobile phone assets you create that belong to that asset model, the custom fields attributes will automatically appear.

To break it down step by step:

- Create the new custom fields you want in your custom fieldset.
- Create the new custom fieldset, and add the custom fields you just created.
- Go to Admin > Asset Models and edit an asset model, selecting the custom fieldset you just created.

You can create the fields first, or the fieldset first, but be sure to add the new fields to your fieldset, and then associate that fieldset to an asset model to see those new fields on your asset forms.

Once your asset models have custom fieldsets associated with them, your new values will appear on the asset view and edit pages, and in the main asset listing table. You will be able to search/sort on these fields (as well as show/hide them in the table view) the same as you can the other built-in fields.

### Custom Field Validation

We have provided support for basic input validation on the custom fields you create. When creating the fields, you'll have the option of selecting the `Format` the text input for your new fields should be in when your admins add or edit assets. You have several pre-defined options:

| Format  | Description |
| ------------- | ------------- |
|`ANY`|No input validation. Any text is acceptable.|
|`ALPHA`|Any alpha numeric text.|
|`NUMERIC`|Any numeric text.|
|`MAC`|Text formatted in MAC address format.|
|`IP`|Text formatted as an IPv4 address. (IPv6 is coming soon.)|
|`CUSTOM`|Custom regular expression.|

If you select `CUSTOM`, be sure to enter a valid regular expression in the `Custom Format` box below that select box.

### Notes:

There is currently no ability to import custom fields while importing assets. That's coming soon.
