<?php

return array(

<<<<<<< HEAD
    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'User already exists!',
    'user_not_found'            => 'User [:id] does not exist.',
    'user_login_required'       => 'The login field is required',
    'user_password_required'    => 'The password is required.',
    'insufficient_permissions'  => 'Insufficient Permissions.',
    'user_deleted_warning'      => 'This user has been deleted. You will have to restore this user to edit them or assign them new assets.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'User was successfully created.',
        'update'    => 'User was successfully updated.',
        'delete'    => 'User was successfully deleted.',
        'ban'       => 'User was successfully banned.',
        'unban'     => 'User was successfully unbanned.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'User was successfully restored.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'There was an issue creating the user. Please try again.',
        'update' => 'There was an issue updating the user. Please try again.',
        'delete' => 'There was an issue deleting the user. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
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
=======
    'accepted'                  => '您已接受這項資產。',
    'declined'                  => '您已拒絕這項資產。',
    'user_exists'               => '使用者已存在！',
    'user_not_found'            => '使用者 [:id] 不存在',
    'user_login_required'       => '登入欄位是必需的',
    'user_password_required'    => '密碼欄位是必需的',
    'insufficient_permissions'  => '權限不足',
    'user_deleted_warning'      => '此使用者已被刪除。您必須先還原此使用者才能進行編輯或分配新的資產。',
    'ldap_not_configured'        => 'LDAP 整合尚未設定',


    'success' => array(
        'create'    => '新增使用者成功。',
        'update'    => '更新使用者成功。',
        'delete'    => '刪除使用者成功。',
        'ban'       => '禁止使用者成功。',
        'unban'     => '解禁使用者成功。',
        'suspend'   => '停用使用者成功。',
        'unsuspend' => '解除停用使用者成功。',
        'restored'  => '恢復使用者成功。',
        'import'    => '匯入使用者成功。',
    ),

    'error' => array(
        'create' => '新增使用者失敗，請重試。',
        'update' => '更新使用者失敗，請重試。',
        'delete' => '刪除使用者失敗，請重試。',
        'unsuspend' => '解除停用使用者失敗，請重試。',
        'import'    => '匯入使用者失敗，請重試。',
        'asset_already_accepted' => '資產已被接受',
        'accept_or_decline' => '您必須選擇接受或拒絕該資產。',
        'incorrect_user_accepted' => '您正嘗試接受的資產未分配給您',
        'ldap_could_not_connect' => '無法連接到 LDAP 伺服器，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_bind' => '無法綁定 LDAP 伺服器，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_search' => '查詢 LDAP 伺服器失敗，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_get_entries' => ' LDAP 伺服器取得資訊條目失敗，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
    ),

    'deletefile' => array(
        'error'   => '刪除檔案失敗，請重試',
        'success' => '刪除檔案成功。',
    ),

    'upload' => array(
        'error'   => '上傳檔案失敗，請重試',
        'success' => '上傳檔案成功。',
        'nofiles' => '尚未選擇要上傳的檔案',
        'invalidfiles' => '一個或多個檔案太大或屬於不被允許的檔案類型。允許上傳的檔案類型：png, gif, jpg, doc, docx, pdf, txt。',
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),

);
