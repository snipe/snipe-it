<?php

return array(

    'does_not_exist' => '分类不存在。',
    'assoc_users'	 => '配件目前状态：可用数量不足，请检查改配件再重试。',

    'create' => array(
        'error'   => '分类创建失败，请重试。',
        'success' => '分类创建成功。'
    ),

    'update' => array(
        'error'   => '分类创建失败，请重试',
        'success' => '分类更新成功。'
    ),

    'delete' => array(
        'confirm'   => '你确定要删除这个分类吗？',
        'error'   => '删除分类出现异常，请重试。',
        'success' => '分类已经被成功删除。'
    ),
    
     'checkout' => array(
        'error'   		=> '配件不能被预订，请重试。',
        'success' 		=> '配件成功预订。',
        'user_does_not_exist' => '无效用户，请重试。'
    ),

    'checkin' => array(
        'error'   		=> '附件未成功入库，请再试一次',
        'success' 		=> '配件入库成功。',
        'user_does_not_exist' => '无效用户，请重试。'
    )


);
