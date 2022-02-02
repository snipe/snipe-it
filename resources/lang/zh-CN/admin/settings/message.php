<?php

return [

    'update' => [
        'error'                 => '更新过程中出现了问题。',
        'success'               => '设置配置信息更新成功。',
    ],
    'backup' => [
        'delete_confirm'        => '你确定你想要删除该备份文件? 此操作无法撤消。 ',
        'file_deleted'          => '备份文件已成功删除。 ',
        'generated'             => '成功地创建了一个新的备份文件。',
        'file_not_found'        => '在服务器上找不到备份文件。',
        'restore_warning'       => '是的，还原它。我承认这将覆盖当前数据库中的任何现有数据。 这也将注销您现有的所有用户 (包括您)。',
        'restore_confirm'       => '您确定要从 :filename还原您的数据库吗？'
    ],
    'purge' => [
        'error'     => '清除过程中出现了错误。 ',
        'validation_failed'     => '你的清除确认不正确，请在输入框中输入“DELETE”。',
        'success'               => '删除记录已被成功的清除。',
    ],
    'mail' => [
        'sending' => '正在发送测试邮件...',
        'success' => '邮件已发送！',
        'error' => '邮件无法发送。',
        'additional' => '没有提供额外的错误信息。请检查您的邮件设置和应用日志。'
    ],
    'ldap' => [
        'testing' => '测试 LDAP 连接，绑定和查询 ...',
        '500' => '500 服务器错误。请检查您的服务器日志以获取更多信息。',
        'error' => '出错了:(',
        'sync_success' => '基于您的设置，从LDAP服务器返回的10个用户样本：',
        'testing_authentication' => '测试 LDAP 身份验证...',
        'authentication_success' => '用户已成功通过LDAP认证！'
    ],
    'slack' => [
        'sending' => '正在发送Slack测试消息...',
        'success_pt1' => '成功！请检查 ',
        'success_pt2' => ' 您的测试消息频道，并且一定要点击下面的“保存”来存储您的设置。',
        '500' => '500 服务器错误。',
        'error' => '出了错。',
    ]
];
