<?php

return array(

    'does_not_exist' => '配件[:id] 不存在。',
    'assoc_users'	 => '配件目前状态：可用数量不足，请检查改配件再重试。',

    'create' => array(
        'error'   => '配件添加失败，请重试。',
        'success' => '配件添加成功。'
    ),

    'update' => array(
        'error'   => '配件更新失败，请重试。',
        'success' => '配件更新成功。'
    ),

    'delete' => array(
        'confirm'   => '你确定要删除此配件？',
        'error'   => '删除配件出错，请重试。',
        'success' => '删除配件成功'
    ),

     'checkout' => array(
        'error'   		=> '配件不能被预订，请重试。',
        'success' 		=> '配件成功预订。',
        'unavailable'   => '配件不可被借出。检查可用数量',
        'user_does_not_exist' => '无效用户，请重试。'
    ),

    'checkin' => array(
        'error'   		=> '附件未成功入库，请再试一次',
        'success' 		=> '配件入库成功。',
        'user_does_not_exist' => '无效用户，请重试。'
    )


);
