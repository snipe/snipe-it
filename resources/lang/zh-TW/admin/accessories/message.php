<?php

return array(

    'does_not_exist' => '配件 [:id] 不存在',
    'not_found' => '沒有找到該配件',
    'assoc_users'	 => '使用者目前已借出 :count 組配件。請在繳回配件後重試。 ',

    'create' => array(
        'error'   => '新增配件失敗，請重試。',
        'success' => '新增配件成功。'
    ),

    'update' => array(
        'error'   => '更新配件失敗，請重試。',
        'success' => '更新配件成功。'
    ),

    'delete' => array(
        'confirm'   => '您確定要刪除此配件嗎？',
        'error'   => '刪除配件時發生問題。請再試一次。',
        'success' => '刪除配件成功。'
    ),

     'checkout' => array(
        'error'   		=> '配件借出失敗。請再試一次。',
        'success' 		=> '借出配件成功。',
        'unavailable'   => '配件不足無法借出, 檢查可用數量.',
        'user_does_not_exist' => '使用者不正確。請再試一次。',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> '配件繳回失敗。請再試一次。',
        'success' 		=> '繳回配件成功。',
        'user_does_not_exist' => '使用者不正確。請再試一次。'
    )


);
