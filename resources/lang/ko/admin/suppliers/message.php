<?php

return array(

    'does_not_exist' => '공급자가 존재하지 않습니다.',


    'create' => array(
        'error'   => '공급자가 생성되지 않았습니다. 다시 시도해 주세요.',
        'success' => '공급자가 생성되었습니다.'
    ),

    'update' => array(
        'error'   => '공급자가 갱신되지 않았습니다. 다시 시도해 주세요.',
        'success' => '공급자가 갱신 되었습니다.'
    ),

    'delete' => array(
        'confirm'   => '이 공급자를 삭제 하시겠습니까?',
        'error'   => '공급자 삭제 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '공급자가 삭제되었습니다.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
