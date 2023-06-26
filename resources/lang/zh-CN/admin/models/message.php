<?php

return array(

    'does_not_exist' => '模板不存在',
    'no_association' => '没有关联的型号。',
    'no_association_fix' => '这将以怪异且可怕的方式破坏一切。立即编辑此资产并为其指定一个型号。',
    'assoc_users'	 => '本模板下目前还有相关的资产，不能被删除，请删除资产以后，再重试。',


    'create' => array(
        'error'   => '模板没有被创建，请重试。',
        'success' => '模板创建成功。',
        'duplicate_set' => '资产名称、制造商和编号都相同的其它资产模板已存在。',
    ),

    'update' => array(
        'error'   => '模板没有被更新，请重试。',
        'success' => '模板更新成功。',
    ),

    'delete' => array(
        'confirm'   => '你确定删除这个模板吗？',
        'error'   => '删除模板的过程中出现了一点儿问题，请重试。',
        'success' => '模板已经成功被删除'
    ),

    'restore' => array(
        'error'   		=> '型号未被恢复，请重试。',
        'success' 		=> '型号恢复成功。'
    ),

    'bulkedit' => array(
        'error'   		=> '没有字段被更改，因此没有更新任何内容。',
        'success' 		=> '型号已成功更新|:model_count 个型号已成功更新。',
        'warn'          => '您将要更新以下型号的属性：|您将要编辑 :model_count 个型号的属性：',

    ),

    'bulkdelete' => array(
        'error'   		    => '没有型号被选中，所以没有删除任何东西。',
        'success' 		    => '型号已删除！|:succes_count 个型号已删除！',
        'success_partial' 	=> ':success_count 个已删除, 但是 :fail_count 个因为还有关联资产所以没办法删除。'
    ),

);
