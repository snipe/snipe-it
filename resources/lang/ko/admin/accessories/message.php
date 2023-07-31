<?php

return array(

    'does_not_exist' => '해당 악세사리 [:id] 가 존재하지 않습니다.',
    'assoc_users'	 => '이 부속품은 현재 사용자에게 :count 개가 반출 되었습니다. 이 부속품을 반입하고 다시 시도해 주세요. ',

    'create' => array(
        'error'   => '부속품을 만들 수 없었습니다. 재시도해 주세요.',
        'success' => '부속품을 만들었습니다.'
    ),

    'update' => array(
        'error'   => '부속품을 갱신하지 못했습니다. 재시도해 주세요.',
        'success' => '부속품을 갱신했습니다.'
    ),

    'delete' => array(
        'confirm'   => '이 부속품을 삭제하시겠습니까?',
        'error'   => '분류 삭제 중 문제가 발생했습니다. 다시 시도해 주세요.',
        'success' => '해당 부속품이 삭제 완료 되었습니다.'
    ),

     'checkout' => array(
        'error'   		=> '부속품이 반출되지 않았습니다. 다시 시도해 주세요.',
        'success' 		=> '부속품이 반출 되었습니다.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.'
    ),

    'checkin' => array(
        'error'   		=> '부속품이 반입되지 않았습니다. 다시 시도해 주세요.',
        'success' 		=> '부속품이 반입 되었습니다.',
        'user_does_not_exist' => '잘못된 사용자 입니다. 다시 시도해 주세요.'
    )


);
