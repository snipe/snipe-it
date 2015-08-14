<?php

return array(

    'accepted'                  => 'この資産を承認しました。',
    'declined'                  => 'この資産を却下しました。',
    'user_exists'               => '利用者が既に存在しています!',
    'user_not_found'            => '利用者 [:id] は、存在していません。',
    'user_login_required'       => 'ログインフィールドが必要です。',
    'user_password_required'    => 'パスワードが必要です。',
    'insufficient_permissions'  => '権限が不足しています。',
    'user_deleted_warning'      => '利用者が削除されました。これらを編集するにはユーザーを復旧するか、新しい資産を割り当てなければなりません。',


    'success' => array(
        'create'    => '利用者が正常に作成されました。',
        'update'    => '利用者が正常に更新されました。',
        'delete'    => '利用者が正常に削除されました。',
        'ban'       => '利用者が正常に禁止されました。',
        'unban'     => '利用者が正常に解禁されました。',
        'suspend'   => 'ユーザーが正常に中断されました。',
        'unsuspend' => 'ユーザーは正常に再開しました。',
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
