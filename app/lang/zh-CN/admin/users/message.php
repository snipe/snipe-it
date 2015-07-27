<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => '用户已经存在!',
    'user_not_found'            => '用户[:id] 不存在',
    'user_login_required'       => '登陆字段是必须的',
    'user_password_required'    => '密码为必填项',
    'insufficient_permissions'  => '权限不足',
    'user_deleted_warning'      => '用户已经被删除，你需要恢复这个用户编辑他或者重新指定新资产。',


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
        'accept_or_decline' => 'You must either accept or decline this asset.',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
