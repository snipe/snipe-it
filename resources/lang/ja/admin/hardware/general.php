<?php

return [
    'about_assets_title'           => '資産について',
    'about_assets_text'            => '資産はシリアル番号や資産タグで追跡します。資産は特定することが重要な、高価な物であることが多いです。',
    'archived'  				=> 'アーカイブ',
    'asset'  					=> '資産',
    'bulk_checkout'             => '一括チェックアウト',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> '資産をチェックイン',
    'checkout'  				=> '資産をチェックアウト',
    'clone'  					=> '資産を複製',
    'deployable'  				=> '配備可能',
    'deleted'  					=> 'この資産は削除されました。',
    'edit'  					=> '資産を編集',
    'model_deleted'  			=> 'この資産モデルは削除されました。資産を復元する前に、モデルを復元する必要があります。',
    'requestable'               => '要求可能',
    'requested'				    => '要求済',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> '資産を復元',
    'pending'  					=> 'ペンディング',
    'undeployable'  			=> '配備不可',
    'view'  					=> '資産を表示',
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
