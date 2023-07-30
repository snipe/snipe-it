<?php

return [
    'about_assets_title'           => 'Vahenditest',
    'about_assets_text'            => 'Varad on üksused, mida jälgitakse seerianumbri või vara tag. Need kipuvad olema kõrgema väärtusega esemed, kus konkreetse üksuse kindlakstegemine on oluline.',
    'archived'  				=> 'Arhiveeritud',
    'asset'  					=> 'Vahend',
    'bulk_checkout'             => 'Vara kasutusele võtt',
    'bulk_checkin'              => 'Vahendite tagastus',
    'checkin'  					=> 'Checkin Asset',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Klooni vahend',
    'deployable'  				=> 'Käivitatav',
    'deleted'  					=> 'See vara on kustutatud.',
    'edit'  					=> 'Muuda vahendit',
    'model_deleted'  			=> 'See vara mudel on kustutatud. Enne vara taastamist peab taastama mudeli.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Taotletav',
    'requested'				    => 'Taotletud',
    'not_requestable'           => 'Mittetaotletav',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Taasta vara',
    'pending'  					=> 'Ootel',
    'undeployable'  			=> 'Kasutuselevõtmatu',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Vaata vahendit',
    'csv_error' => 'Sul on viga CSV failis:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Tõrked:',
    'success_messages' => 'Õnnestumised:',
    'alert_details' => 'Palun vaata allolevaid üksikasju.',
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];
