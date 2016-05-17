<?php

return array(

    'does_not_exist' => '分类不存在',
    'assoc_models'	 => 'This category is currently associated with at least one model and cannot be deleted. Please update your models to no longer reference this category and try again. ',
    'assoc_items'	 => 'This category is currently associated with at least one :asset_type and cannot be deleted. Please update your :asset_type  to no longer reference this category and try again. ',

    'create' => array(
        'error'   => '分类创建失败，请重试。',
        'success' => '分类创建成功'
    ),

    'update' => array(
        'error'   => '分类更新失败，请重试',
        'success' => '分类更新成功'
    ),

    'delete' => array(
        'confirm'   => '你确定要删除这个分类吗？',
        'error'   => '删除分类出现异常，请重试。',
        'success' => '分类已经被成功删除。'
    )

);
