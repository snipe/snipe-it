<?php

return [
    'about_assets_title'           => '关于资产',
    'about_assets_text'            => '资产是按照序列号或者资产标签跟踪的物品。可以标记特殊物品为高价值资产。',
    'archived'  				=> '已存档',
    'asset'  					=> '资产',
    'bulk_checkout'             => '分配资产',
    'checkin'  					=> '借入资产',
    'checkout'  				=> '借出资产',
    'clone'  					=> '复制资产',
    'deployable'  				=> '可部署',
    'deleted'  					=> '此资产已被删除。',
    'edit'  					=> '编辑资产',
    'model_deleted'  			=> '这个资源模型已被删除。您必须先还原模型才能还原素材。',
    'requestable'               => '可申领',
    'requested'				    => '已申请',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> '还原资产',
    'pending'  					=> '待处理',
    'undeployable'  			=> '不可部署',
    'view'  					=> '查看资产',
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
