<?php

return array(

    'does_not_exist' => '位置不存在',
    'assoc_users'	 => '该位置下管理的还有其他用户，目前不能删除，请更新该用户的信息之后，再尝试删除。',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => '位置没有被创建，请重试。',
        'success' => '位置创建成功。'
    ),

    'update' => array(
        'error'   => '位置没有被更新，请重试。',
        'success' => '位置更新成功。'
    ),

    'delete' => array(
        'confirm'   	=> '确定删除这个位置吗?',
        'error'   => '删除位置的过成中出现了一点儿问题，请重试。',
        'success' => '位置已经成功删除。'
    )

);
