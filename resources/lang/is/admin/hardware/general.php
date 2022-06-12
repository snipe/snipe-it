<?php

return [
    'about_assets_title'           => 'Um eignir',
    'about_assets_text'            => 'Eignir eru hlutir sem hægt er að rekja með raðnúmeri eða öðrum merkingum. Þær eru alla jafna verðmætir hlutir sem mikilvægt er að geta aðgreint og borið kennsl á.',
    'archived'  				=> 'Safnvistað',
    'asset'  					=> 'Eign',
    'bulk_checkout'             => 'Ráðstafa eignum',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Skila eign',
    'checkout'  				=> 'Ráðstafa eign',
    'clone'  					=> 'Clone Asset',
    'deployable'  				=> 'Nothæfar',
    'deleted'  					=> 'This asset has been deleted.',
    'edit'  					=> 'Breyta eign',
    'model_deleted'  			=> 'This Assets model has been deleted. You must restore the model before you can restore the Asset.',
    'requestable'               => 'Requestable',
    'requested'				    => 'Requested',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Restore Asset',
    'pending'  					=> 'Á bið',
    'undeployable'  			=> 'Ónothæfar',
    'view'  					=> 'Skoða eign',
    'csv_error' => 'Það er villa í CSV skránni þinni:',
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
    'error_messages' => 'Error messages:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Please see below for details.',
    'custom_export' => 'Custom Export'
];
