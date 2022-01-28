<?php

return [
    'about_assets_title'           => 'Over assets',
    'about_assets_text'            => 'Assets zijn items die worden bijgehouden op serienummer of een tag van het product. Het zijn meestal items met een hogere waarde waarbij het identificeren van een specifiek item belangrijk is.',
    'archived'  				=> 'Gearchiveerd',
    'asset'  					=> 'Asset',
    'bulk_checkout'             => 'Asset uitchecken',
    'checkin'  					=> 'Asset inchecken',
    'checkout'  				=> 'Asset uitchecken',
    'clone'  					=> 'Dupliceer Asset',
    'deployable'  				=> 'Uitgeefbaar',
    'deleted'  					=> 'Deze asset is verwijderd.',
    'edit'  					=> 'Asset bewerken',
    'model_deleted'  			=> 'Dit Assets model is verwijderd. U moet het model herstellen voordat u het Asset kunt herstellen.',
    'requestable'               => 'Aanvraagbaar',
    'requested'				    => 'Aangevraagd',
    'not_requestable'           => 'Niet aanvraagbaar',
    'requestable_status_warning' => 'Verander de aanvraagbare status niet',
    'restore'  					=> 'Herstel Asset',
    'pending'  					=> 'In behandeling',
    'undeployable'  			=> 'Niet uitgeefbaar',
    'view'  					=> 'Bekijk Asset',
    'csv_error' => 'Je hebt een fout in je CSV-bestand:',
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
    'error_messages' => 'Foutmeldingen:',
    'success_messages' => 'Succesvolle berichten:',
    'alert_details' => 'Zie hieronder voor details.',
    'custom_export' => 'Aangepaste export'
];
