<?php

return [
    'about_assets_title'           => 'Tentang Aset',
    'about_assets_text'            => 'Aset adalah barang yang dilacak dengan nomor seri atau tanda aset. Cenderung menjadi barang dengan nilai lebih tinggi dimana identifikasi barang secara spesifik berpengaruh.',
    'archived'  				=> 'Diarsipkan',
    'asset'  					=> 'Aset',
    'bulk_checkout'             => 'Pengeluaran Aset',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Pengembalian aset',
    'checkout'  				=> 'Aset Checkout',
    'clone'  					=> 'Klon Aset',
    'deployable'  				=> 'Dapat digunakan',
    'deleted'  					=> 'Aset ini telah dihapus.',
    'edit'  					=> 'Sunting Aset',
    'model_deleted'  			=> 'Model Aset ini telah dihapus. Anda harus memulihkan model aset tersebut sebelum Anda dapat memulihkan Aset.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Dapat diminta',
    'requested'				    => 'Telah diminta',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Mengembalikan aset',
    'pending'  					=> 'Tunda',
    'undeployable'  			=> 'Tidak dapat digunakan',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Tampilkan aset',
    'csv_error' => 'You have an error in your CSV file:',
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
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];
