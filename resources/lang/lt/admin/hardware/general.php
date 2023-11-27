<?php

return [
    'about_assets_title'           => 'Apie turtą',
    'about_assets_text'            => 'Turtas - tai daiktai, kurie stebimi serijos numeriu arba turinio žyma. Jie dažniausiai būna vertingesni dalykai, kai svarbu nustatyti konkretų elementą.',
    'archived'  				=> 'Archyvuota',
    'asset'  					=> 'Įranga',
    'bulk_checkout'             => 'Išduota įranga',
    'bulk_checkin'              => 'Priimti įrangą',
    'checkin'  					=> 'Išduota įranga',
    'checkout'  				=> 'Patikros turtas',
    'clone'  					=> 'Kopijuoti įrangą',
    'deployable'  				=> 'Naudojamas',
    'deleted'  					=> 'Ši įranga buvo ištrinta.',
    'delete_confirm'            => 'Are you sure you want to delete this asset?',
    'edit'  					=> 'Keisti įrangą',
    'model_deleted'  			=> 'This Assets model has been deleted. You must restore the model before you can restore the Asset.',
    'model_invalid'             => 'Neteisingas įrangos modelis.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Reiklaujamas',
    'requested'				    => 'Užklausta',
    'not_requestable'           => 'Nereikalaujamas',
    'requestable_status_warning' => 'Do not change requestable status',
    'restore'  					=> 'Atkurti įrangą',
    'pending'  					=> 'Vykdoma',
    'undeployable'  			=> 'Negalimas naudoti',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Peržiūrėti įrangą',
    'csv_error' => 'Jūsų CSV faile yra klaida:',
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
    'csv_import_match_username' => 'Pabandykite sulyginti naudotojus pagal naudotojo vardą',
    'error_messages' => 'Klaidos pranešimai:',
    'success_messages' => 'Sėkmės pranešimai:',
    'alert_details' => 'Žemiau pateikta detalesnė informacija.',
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
    'user_department' => 'Naudotojo departamentas',
];
