<?php

return [
    'custom_fields'		        => 'Pritaikyti laukai',
    'manage'                    => 'Manage',
    'field'		                => 'Laukas',
    'about_fieldsets_title'		=> 'Apie laukų grupes',
    'about_fieldsets_text'		=> 'Fieldsets allow you to create groups of custom fields that are frequently re-used for specific asset model types.',
    'custom_format'             => 'Custom Regex format...',
    'encrypt_field'      	        => 'Šifruoti šio lauko vertę duomenų bazėje',
    'encrypt_field_help'      => 'ĮSPĖJIMAS: lauko šifravimas daro jį nepastebimos.',
    'encrypted'      	        => 'Šifruotas',
    'fieldset'      	        => 'Laukų grupė',
    'qty_fields'      	      => 'Laukų kiekis',
    'fieldsets'      	        => 'Laukų grupės',
    'fieldset_name'           => 'Laukų grupės pavadinimas',
    'field_name'              => 'Lauko pavadinimas',
    'field_values'            => 'Lauko vertės',
    'field_values_help'       => 'Pridėti pasirinktinas parinktis, po vieną eilutėje. Tuščios eilutės, išskyrus pirmąją eilutę, bus ignoruojamos.',
    'field_element'           => 'Laukelio elementas',
    'field_element_short'     => 'Elementas',
    'field_format'            => 'Formatas',
    'field_custom_format'     => 'Pritaikomas formatas',
    'field_custom_format_help'     => 'Šis laukelis leidžia Jums naudoti REGEX validaciją. Tai turėtų prasidėti "regax:" - pavyzdžiui norint validuoti pasirinkto laukelio reikšmę IMEI (15 skaičių), privalote naudoti <code>regex:/^[0-9]{15}$/</code>.',
    'required'   		          => 'Privalomas',
    'req'   		              => 'Privaloma.',
    'used_by_models'   		    => 'Naudojama modelių',
    'order'   		            => 'Užsakymas',
    'create_fieldset'         => 'Nauja laukų grupė',
    'update_fieldset'         => 'Update Fieldset',
    'fieldset_does_not_exist'   => 'Fieldset :id does not exist',
    'fieldset_updated'         => 'Fieldset updated',
    'create_fieldset_title' => 'Create a new fieldset',
    'create_field'            => 'Naujas pritaikomas laukelis',
    'create_field_title' => 'Create a new custom field',
    'value_encrypted'      	        => 'Šio lauko vertė yra užkoduota duomenų bazėje. Tik admin vartotojai galės peržiūrėti iššifruotą vertę',
    'show_in_email'     => 'Įterptos šio laukelio išdavimo reikšmės bus siunčiamos vartotojams? Užšifruoti laukai negali būti įterpti į el. laišką.',
    'help_text' => 'Help Text',
    'help_text_description' => 'This is optional text that will appear below the form elements while editing an asset to provide context on the field.',
    'about_custom_fields_title' => 'About Custom Fields',
    'about_custom_fields_text' => 'Custom fields allow you to add arbitrary attributes to assets.',
    'add_field_to_fieldset' => 'Add Field to Fieldset',
    'make_optional' => 'Required - click to make optional',
    'make_required' => 'Optional - click to make required',
    'reorder' => 'Reorder',
    'db_field' => 'DB Field',
    'db_convert_warning' => 'WARNING. This field is in the custom fields table as <code>:db_column</code> but should be <code>:expected</code>.',
    'is_unique' => 'This value must be unique across all assets',
    'unique' => 'Unique',
    'display_in_user_view' => 'Allow the checked out user to view these values in their View Assigned Assets page',
    'display_in_user_view_table' => 'Visible to User',
    'auto_add_to_fieldsets' => 'Automatically add this to every new fieldset',
    'add_to_preexisting_fieldsets' => 'Add to any existing fieldsets',
    'show_in_listview' => 'Show in list views by default. Authorized users will still be able to show/hide via the column selector.',
    'show_in_listview_short' => 'Show in lists',

];
