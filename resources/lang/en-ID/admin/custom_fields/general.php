<?php

return [
    'custom_fields'		        => 'Bidang Kustom',
    'manage'                    => 'Manage',
    'field'		                => 'Bidang',
    'about_fieldsets_title'		=> 'Tentang Fieldsets',
    'about_fieldsets_text'		=> 'Fieldsets allow you to create groups of custom fields that are frequently re-used for specific asset model types.',
    'custom_format'             => 'Custom Regex format...',
    'encrypt_field'      	        => 'Enkripsikan nilai bidang ini di database',
    'encrypt_field_help'      => 'PERINGATAN: Mengenkripsi sebuah field membuatnya tidak bisa ditelusuri.
 .',
    'encrypted'      	        => 'Dienkripsi',
    'fieldset'      	        => 'Fieldset',
    'qty_fields'      	      => 'Qty Fields',
    'fieldsets'      	        => 'Fieldset',
    'fieldset_name'           => 'Nama Fieldset',
    'field_name'              => 'Nama bidang',
    'field_values'            => 'Nilai bidang',
    'field_values_help'       => 'Tambahkan opsi yang dapat dipilih, satu per baris. Baris kosong selain baris pertama akan diabaikan.',
    'field_element'           => 'Elemen formulir',
    'field_element_short'     => 'Elemen',
    'field_format'            => 'Format',
    'field_custom_format'     => 'Format kostum regex',
    'field_custom_format_help'     => 'Bidang ini memungkinkan Anda menggunakan ekspresi regex untuk validasi. Ini harus dimulai dengan "regex:" - misalnya, untuk memvalidasi bahwa nilai field kustom berisi IMEI yang valid (15 angka numerik), Anda akan menggunakan <code>regex:/^[0-9]{15}$/</code>.',
    'required'   		          => 'Diperlukan',
    'req'   		              => 'Req.',
    'used_by_models'   		    => 'Digunakan oleh Model',
    'order'   		            => 'Pesanan',
    'create_fieldset'         => 'Atur bidang baru',
<<<<<<< HEAD
    'update_fieldset'         => 'Update Fieldset',
    'fieldset_does_not_exist'   => 'Fieldset :id does not exist',
    'fieldset_updated'         => 'Fieldset updated',
=======
>>>>>>> 64747d0fb (updates based on review)
    'create_fieldset_title' => 'Create a new fieldset',
    'create_field'            => 'Kostum field baru',
    'create_field_title' => 'Create a new custom field',
    'value_encrypted'      	        => 'Nilai field ini dienkripsi dalam database. Hanya pengguna admin yang bisa melihat nilai dekripsi',
<<<<<<< HEAD
    'show_in_email'     => 'Sertakan nilai bidang ini dalam semua email keluar yang dikirim ke pengguna? Bidang yang terenkripsi tidak dapat disertakan dalam email',
    'show_in_email_short'     => 'Include in emails.',
=======
    'show_in_email'     => 'Sertakan nilai bidang ini dalam semua email keluar yang dikirim ke pengguna? Bidang yang terenkripsi tidak dapat disertakan dalam email.',
>>>>>>> 64747d0fb (updates based on review)
    'help_text' => 'Help Text',
    'help_text_description' => 'This is optional text that will appear below the form elements while editing an asset to provide context on the field.',
    'about_custom_fields_title' => 'About Custom Fields',
    'about_custom_fields_text' => 'Custom fields allow you to add arbitrary attributes to assets.',
    'add_field_to_fieldset' => 'Add Field to Fieldset',
    'make_optional' => 'Required - click to make optional',
    'make_required' => 'Optional - click to make required',
    'reorder' => 'Reorder',
    'db_field' => 'DB Field',
<<<<<<< HEAD
    'db_convert_warning' => 'WARNING. This field is in the custom fields table as <code>:db_column</code> but should be <code>:expected</code>.',
    'is_unique' => 'This value must be unique across all assets',
    'unique' => 'Unique',
    'display_in_user_view' => 'Allow the checked out user to view these values in their View Assigned Assets page',
    'display_in_user_view_table' => 'Visible to User',
    'auto_add_to_fieldsets' => 'Automatically add this to every new fieldset',
    'add_to_preexisting_fieldsets' => 'Add to any existing fieldsets',
    'show_in_listview' => 'Show in list views by default. Authorized users will still be able to show/hide via the column selector',
    'show_in_listview_short' => 'Show in lists',
    'show_in_requestable_list_short' => 'Show in requestable assets list',
    'show_in_requestable_list' => 'Show value in requestable assets list. Encrypted fields will not be shown',
    'encrypted_options' => 'This field is encrypted, so some display options will not be available.',

=======
    'db_convert_warning' => 'WARNING. This field is in the custom fields table as <code> :db_column </code> but should be :expected </code>.'
>>>>>>> 64747d0fb (updates based on review)
];
