<?php

return array(

    'accepted'                  => '你已成功接受此项资产。',
    'declined'                  => '你已拒绝此项资产。',
    'bulk_manager_warn'	        => '您的用户已成功更新，但是您的经理条目未保存，因为您选择的经理也在要编辑的用户列表中，用户可能不是自己的经理。请再次选择您的用户，不包括经理。',
    'user_exists'               => '用户已经存在!',
    'user_not_found'            => '用户不存在。',
    'user_login_required'       => '登陆字段是必须的',
    'user_password_required'    => '密码为必填项',
    'insufficient_permissions'  => '权限不足',
    'user_deleted_warning'      => '用户已经被删除，你需要恢复这个用户编辑他或者重新指定新资产。',
    'ldap_not_configured'        => '安装过程中未启用LDAP集成的功能。',
    'password_resets_sent'      => '被选中的已激活并拥有有效电子邮件地址的用户已经收到了一个密码重置链接。',
    'password_reset_sent'       => '密码重置链接已发送至 :email!',
    'user_has_no_email'         => '此用户的个人资料中没有电子邮件地址。',
    'user_has_no_assets_assigned'   => '此用户没有分配任何资产',


    'success' => array(
        'create'    => '用户创建成功',
        'update'    => '用户更新成功。',
        'update_bulk'    => '用户更新成功。',
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
        'delete_has_assets' => '此用户具有分配的项目，无法删除。',
        'unsuspend' => '恢复停用用户的过程中出现了一点儿问题，请重试。',
        'import'    => '导入用户出现问题。请再试一次。',
        'asset_already_accepted' => '资产已被接受',
        'accept_or_decline' => '你必须选择接受或者拒绝该资产。',
        'incorrect_user_accepted' => '您正尝试接受的资产未被分配与您',
        'ldap_could_not_connect' => '无法连接到LDAP服务器，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
        'ldap_could_not_bind' => '无法绑定到LDAP服务器，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息: ',
        'ldap_could_not_search' => '查询LDAP服务器失败，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
        'ldap_could_not_get_entries' => '从LDAP服务器获取信息条目失败，请检查LDAP配置文件中的相关设置。<br>LDAP服务器错误信息:',
        'password_ldap' => '此帐户的密码由LDAP / Active Directory管理。请联系您的IT部门更改您的密码。',
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

    'inventorynotification' => array(
        'error'   => '此用户没有设置电子邮件。',
        'success' => '已通知用户其当前库存。'
    )
);