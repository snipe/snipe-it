<?php

return [
    'about_assets_title'           => 'Varlıklar hakkında',
    'about_assets_text'            => 'Varlıklar Demirbaştır seri numarası veya varlık etiketi ile takibi yapılır. Bu nedenle değerli varlıklar benzersiz varlık kimliği ile ilişkilendirilirler.',
    'archived'  				=> 'Arşivlenmiş',
    'asset'  					=> 'Demirbaş',
    'bulk_checkout'             => 'Varlıkları Kullanıma Alma',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Demirbaş Girişi Yap',
    'checkout'  				=> 'Ödenme Öğe',
    'clone'  					=> 'Demirbaşı Kopyala',
    'deployable'  				=> 'Dağıtılabilir',
    'deleted'  					=> 'Bu varlık silindi.',
    'edit'  					=> 'Demirbaşı Düzenle',
    'model_deleted'  			=> 'Bu varlık modeli silindi. Varlığı geri almak için modelini geri almalısınız.',
    'requestable'               => 'Talep edilebilir',
    'requested'				    => 'Talep edildi',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Demirbaşı Geri Getir',
    'pending'  					=> 'Bekliyor',
    'undeployable'  			=> 'Dağtılamaz',
    'view'  					=> 'Demirbaşı Görüntüle',
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
    'custom_export' => 'Custom Export'
];
