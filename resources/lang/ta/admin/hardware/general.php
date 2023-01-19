<?php

return [
    'about_assets_title'           => 'சொத்துகள் பற்றி',
    'about_assets_text'            => 'சொத்துகள் வரிசை எண் அல்லது சொத்து குறிச்சொல் மூலம் கண்காணிக்கப்படும் உருப்படிகளாக இருக்கின்றன. ஒரு குறிப்பிட்ட உருப்படி விஷயங்களை அடையாளம் காண்பிக்கும் அதிக மதிப்புள்ள பொருட்களாக அவை இருக்கும்.',
    'archived'  				=> 'காப்பகப்படுத்தியவை',
    'asset'  					=> 'சொத்து',
    'bulk_checkout'             => 'Checkout Assets',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'சரிபார்ப்பு சொத்து',
    'checkout'  				=> 'சரிபார்ப்புச் சொத்து',
    'clone'  					=> 'குளோன் சொத்து',
    'deployable'  				=> 'அணியப்படுத்தக்',
    'deleted'  					=> 'This asset has been deleted.',
    'edit'  					=> 'சொத்து திருத்து',
    'model_deleted'  			=> 'This Assets model has been deleted. You must restore the model before you can restore the Asset.',
    'requestable'               => 'Requestable',
    'requested'				    => 'கோரப்பட்டது',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'சொத்து மீட்டமை',
    'pending'  					=> 'நிலுவையில்',
    'undeployable'  			=> 'Undeployable',
    'view'  					=> 'சொத்து காண்க',
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
