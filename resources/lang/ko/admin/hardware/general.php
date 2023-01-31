<?php

return [
    'about_assets_title'           => '자산이란',
    'about_assets_text'            => '자산은 일련 번호나 자산 꼬리표로 추적되는 품목들입니다. 특정 품목의 상황을 파악하는 것이 더 높은 가치를 갖는 추세입니다.',
    'archived'  				=> '보관됨',
    'asset'  					=> '자산',
    'bulk_checkout'             => '반출 자산',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> '반입 자산',
    'checkout'  				=> '반출 자산',
    'clone'  					=> '자산 복제',
    'deployable'  				=> '사용가능',
    'deleted'  					=> '자산이 삭제되었습니다.',
    'edit'  					=> '자산 수정',
    'model_deleted'  			=> '모델이 삭제되었습니다. 자산을 복원하기 전에 모델을 복원해야 합니다.',
    'requestable'               => '요청가능',
    'requested'				    => '요청됨',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> '자산 복원',
    'pending'  					=> '대기중',
    'undeployable'  			=> '사용불가',
    'view'  					=> '자산 보기',
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
