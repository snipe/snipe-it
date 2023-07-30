<?php

return [
    'about_assets_title'           => 'Par aktīviem',
    'about_assets_text'            => 'Aktīvi ir posteņi, ko izseko pēc sērijas numura vai aktīvu taga. Viņi mēdz būt augstākas vērtības priekšmeti, kad ir svarīgi noteikt konkrētu objektu.',
    'archived'  				=> 'Arhivēts',
    'asset'  					=> 'Aktīvs',
    'bulk_checkout'             => 'Lielapjoma izsniegšana',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Reģistrēšanās aktīvs',
    'checkout'  				=> 'Checkout Asset',
    'clone'  					=> 'Clone Asset',
    'deployable'  				=> 'Izvietojams',
    'deleted'  					=> 'Šis pamatlīdzeklis ir izdzēsts.',
    'edit'  					=> 'Rediģēt īpašumu',
    'model_deleted'  			=> 'Šis pamatlīdzekļu modelis ir dzēsts. Jums ir jāatjauno modelis pirms drīkstiet atjaunot pamatlīdzekli.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Pieļaujams',
    'requested'				    => 'Pieprasīts',
    'not_requestable'           => 'Nav pieprasāms',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Atjaunot aktīvus',
    'pending'  					=> 'Gaida',
    'undeployable'  			=> 'Nodarbināms',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Skatīt aktīvu',
    'csv_error' => 'Jūsu CSV failā ir kļūda:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Mēģiniet sasaistīt lietotājus pēc vārds.uzvārds (jānis.bērziņš) formāta',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Error messages:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Lūdzu skatiet zemāk.',
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];
