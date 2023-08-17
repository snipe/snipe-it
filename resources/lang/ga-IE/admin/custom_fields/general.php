<?php

return [
    'custom_fields'		        => 'Réimsí Saincheaptha',
    'manage'                    => 'Manage',
    'field'		                => 'Gort',
    'about_fieldsets_title'		=> 'Maidir Fieldsets',
    'about_fieldsets_text'		=> 'Fieldsets allow you to create groups of custom fields that are frequently re-used for specific asset model types.',
    'custom_format'             => 'Custom Regex format...',
    'encrypt_field'      	        => 'Criptigh luach an réimse seo sa bhunachar sonraí',
    'encrypt_field_help'      => 'RABHADH: Ní chuireann sé clóscríobh ar réimse.',
    'encrypted'      	        => 'Criptithe',
    'fieldset'      	        => 'Fieldset',
    'qty_fields'      	      => 'Qty Fields',
    'fieldsets'      	        => 'Fieldsets',
    'fieldset_name'           => 'Ainm Fieldset',
    'field_name'              => 'Ainm Réimse',
    'field_values'            => 'Luachanna Réimse',
    'field_values_help'       => 'Cuir roghanna roghnaithe, ceann in aghaidh an líne. Ní dhéanfar neamhaird ar línte bán seachas an chéad líne.',
    'field_element'           => 'Eilimint Foirm',
    'field_element_short'     => 'Eilimint',
    'field_format'            => 'Formáid',
    'field_custom_format'     => 'Formáid Chustaim',
    'field_custom_format_help'     => 'This field allows you to use a regex expression for validation. It should start with "regex:" - for example, to validate that a custom field value contains a valid IMEI (15 numeric digits), you would use <code>regex:/^[0-9]{15}$/</code>.',
    'required'   		          => 'Riachtanach',
    'req'   		              => 'Req.',
    'used_by_models'   		    => 'Úsáidte trí Mhúnlaí',
    'order'   		            => 'Ordú',
    'create_fieldset'         => 'New Fieldset',
    'update_fieldset'         => 'Update Fieldset',
    'fieldset_does_not_exist'   => 'Fieldset :id does not exist',
    'fieldset_updated'         => 'Fieldset updated',
    'create_fieldset_title' => 'Create a new fieldset',
    'create_field'            => 'Réimse Nua Chustaim',
    'create_field_title' => 'Create a new custom field',
    'value_encrypted'      	        => 'Tá luach an réimse seo criptithe sa bhunachar sonraí. Ní bheidh ach úsáideoirí riaracháin in ann an luach díchriptithe a fheiceáil',
    'show_in_email'     => 'Include the value of this field in checkout emails sent to the user? Encrypted fields cannot be included in emails.',
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
