<?php

return [

    'does_not_exist' => '模板不存在',
    'assoc_users'     => '本模板下目前还有相关的资产，不能被删除，请删除资产以后，再重试。',

    'create' => [
        'error'   => '模板没有被创建，请重试。',
        'success' => '模板创建成功。',
        'duplicate_set' => '资产名称、制造商和编号都相同的其它资产模板已存在。',
    ],

    'update' => [
        'error'   => '模板没有被更新，请重试。',
        'success' => '模板更新成功。',
    ],

    'delete' => [
        'confirm'   => '你确定删除这个模板吗？',
        'error'   => '删除模板的过程中出现了一点儿问题，请重试。',
        'success' => '模板已经成功被删除',
    ],

    'restore' => [
        'error'        => '型号未被恢复，请重试。',
        'success'        => '型号恢复成功。',
    ],

    'bulkedit' => [
        'error'        => '没有字段被更改，因此没有更新任何内容。',
        'success'        => '模板已更新。',
    ],

];
