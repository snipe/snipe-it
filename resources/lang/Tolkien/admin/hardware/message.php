<?php

return [

    'undeployable' 		=> '<strong>Gwarn:</strong> Hen nethra na er ú-angrador. Ir hon stat cheneb, atha henneth hon stat.',
    'does_not_exist' 	=> 'Nethra hen ú-en.',
    'does_not_exist_var'=> 'Nethra ben tag :asset_tag ú-dirnen.',
    'no_tag' 	        => 'Ú-amma tag nethra.',
    'does_not_exist_or_not_requestable' => 'Hen nethra ú-en ben er ú-edraedor.',
    'assoc_users'	 	=> 'Nethra hen na checked out na ben, ah ú-er na dor. Hain nethra in athen, atha hedir.',
    'warning_audit_date_mismatch' 	=> 'Audit hon odaneg er ú-handas: (:next_audit_date) sen handas odaneg (:last_audit_date). Hain nethra handas hon.',

    'create' => [
        'error'   		=> 'Nethra ú-chennaen, atha anno ad.',
        'success' 		=> 'Nethra chennaen mae.',
        'success_linked' => 'Nethra ben tag :tag chennaen mae. <strong><a href=":link" style="color: white;">Cen hedir</a></strong>.',
    ],

    'update' => [
        'error'   		=> 'Nethra ú-edroen, atha anno ad.',
        'success' 		=> 'Nethra edroen mae.',
        'encrypted_warning' => 'Nethra edroen mae, ach henaid dhannais ú-noer ahir annon.',
        'nothing_updated'	=>  'Nath nai ú-chant, ú-noer edroen.',
        'no_assets_selected'  =>  'Ú-nethra nai chant, ú-noer edroen.',
        'assets_do_not_exist_or_are_invalid' => 'Nethra chant ú-noer edroen.',
    ],

    'restore' => [
        'error'   		=> 'Nethra ú-sennad, atha anno ad.',
        'success' 		=> 'Nethra sennad mae.',
        'bulk_success' 		=> 'Nethra sennad mae.',
        'nothing_updated'   => 'Ú-nethra nai chant, ú-noer sennad.',
    ],

    'audit' => [
        'error'   		=> 'Audit nethra ú-mae: :error ',
        'success' 		=> 'Audit nethra athraen mae.',
    ],

    'deletefile' => [
        'error'   => 'Cened dor ú-er, atha anno ad.',
        'success' => 'Cened dor mae.',
    ],

    'upload' => [
        'error'   => 'Cened ben ú-er noer, atha anno ad.',
        'success' => 'Cened noer mae.',
        'nofiles' => 'Ú-chant cened noer, ú-cheged i cened cen naer.',
        'invalidfiles' => 'Cened ben ú-na mae: ú-handas cened na ben, á cened png, gif, jpg, doc, docx, pdf, ah txt.',
    ],

    'import' => [
        'import_button'         => 'Othor Import',
        'error'                 => 'In ned ú-hathol mae.',
        'errorDetail'           => 'In ned ú-hathol na dannais.',
        'success'               => 'I file hathol mae.',
        'file_delete_success'   => 'I file hawn mae.',
        'file_delete_error'      => 'I file ú-hawnno.',
        'file_missing' => 'I file ned chant ú-dirnen.',
        'file_already_deleted' => 'I file ned chant hawn anno.',
        'header_row_has_malformed_characters' => 'Manad edhelnen ben header yred enna tharn ben UTF-8.',
        'content_row_has_malformed_characters' => 'Manad edhelnen ben content yred min enna tharn ben UTF-8.',
    ],

    'delete' => [
        'confirm'   	=> 'Ú-er hen dor?',
        'error'   		=> 'Ennas ú-baur hen dor. Atho ad.',
        'nothing_updated'   => 'Ú-nethra chant, ú-noer dor.',
        'success' 		=> 'Hen doren mae.',
    ],

    'checkout' => [
        'error'   		=> 'Hen ú-baur checked out, atho ad.',
        'success' 		=> 'Hen checked out mae.',
        'user_does_not_exist' => 'Nethra ben ú-en. Atho ad.',
        'not_available' => 'Hen ú-angrador an checked out!',
        'no_assets_selected' => 'Naer i han chant asset min list.',
    ],

    'checkin' => [
        'error'   		=> 'Hen ú-baur checked in, atho ad.',
        'success' 		=> 'Hen checked in mae.',
        'user_does_not_exist' => 'Nethra ben ú-en. Atho ad.',
        'already_checked_in'  => 'Hen checked in anno.',
    ],

    'requests' => [
        'error'   		=> 'Hen ú-baur edron, atho ad.',
        'success' 		=> 'Hen edroen mae.',
        'canceled'      => 'Checkout edron ned cennae ú-henn mae.',
    ],

];
