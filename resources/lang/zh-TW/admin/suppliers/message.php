<?php

return array(

    'does_not_exist' => '供應商不存在',


    'create' => array(
        'error'   => '新增供應商失敗，請重試',
        'success' => '新增供應商成功。'
    ),

    'update' => array(
        'error'   => '更新供應商失敗，請重試',
        'success' => '更新供應商成功。'
    ),

    'delete' => array(
        'confirm'   => '您確定要刪除此供應商嗎？',
        'error'   => '刪除供應商失敗，請重試',
        'success' => '刪除供應商成功。',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
