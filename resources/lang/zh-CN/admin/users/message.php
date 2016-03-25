<?php

return array(

    'accepted'                  => '你已成功接受此项资产。',
    'declined'                  => '你已拒绝此项资产。',
    'user_exists'               => '用户已经存在!',
    'user_not_found'            => '用户[:id] 不存在',
    'user_login_required'       => '登陆字段是必须的',
    'user_password_required'    => '密码为必填项',
    'insufficient_permissions'  => '权限不足',
    'user_deleted_warning'      => '用户已经被删除，你需要恢复这个用户编辑他或者重新指定新资产。',
    'ldap_not_configured'        => '安装过程中未启用LDAP集成的功能。',


    'success' => array(
        'create'    => '用户创建成功',
        'update'    => '用户更新成功。',
        'delete'    => '用户已经被删除',
        'ban'       => '用户禁止成功',
        'unban'     => '用户成功解禁',
        'suspend'   => '用户已经成功停用',
        'unsuspend' => '用户解除停用',
        'restored'  => '用户成功被恢复。',
        'import'    => '导入用户成功',
    ),

    'error' => array(
        'create' => '创建用户过程中出现了一些问题，请重试。',
        'update' => '更新用户过程中出现了一些问题，请重试。',
        'delete' => '删除用户过程中出现了一点儿问题，请重试。',
        'unsuspend' => '恢复停用用户的过程中出现了一点儿问题，请重试。',
        'import'    => '导入用户出现问题。请再试一次。',
        'asset_already_accepted' => '资产已被接受',
        'accept_or_decline' => '你必须选择接受或者拒绝该资产。',
        'incorrect_user_accepted' => '您正尝试接受的资产未被分配与您',
        'ldap_could_not_connect' => '无法连接到LDAP服务器，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
        'ldap_could_not_bind' => '无法绑定到LDAP服务器，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息: ',
        'ldap_could_not_search' => '查询LDAP服务器失败，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
        'ldap_could_not_get_entries' => '从LDAP服务器获取信息条目失败，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
    ),

    'deletefile' => array(
        'error'   => '文件删除失败，请重试',
        'success' => '文件已成功删除。',
    ),

    'upload' => array(
        'error'   => '文件上传失败，请重试。',
        'success' => '文件已上传成功。',
        'nofiles' => '您没有选择要上传的文件',
        'invalidfiles' => '一个或多个文件过大或文件类型不被允许。允许上传的文件类型有PNG，GIF，JPG，DOC，DOCX，PDF和TXT。',
    ),

);
