<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> '资产不存在',
    'assoc_users'	 	=> '这个资产目前已经借给某个用户，不能被删除，请检查资产信息，然后再尝试删除。',

    'create' => array(
        'error'   		=> '资产创建失败，请重试。:(',
        'success' 		=> '资产创建成功。 :)'
    ),

    'update' => array(
        'error'   			=> '资产更新失败，请重试。',
        'success' 			=> '资产更新成功。',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
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


    'delete' => array(
        'confirm'   	=> '你确定要删除这个资产吗？',
        'error'   		=> '删除资产的过程中出现了一点儿问题，请重试。',
        'success' 		=> '资产成功被删除。'
    ),

    'checkout' => array(
        'error'   		=> '资产未被借出，请重试',
        'success' 		=> '资产借出成功。',
        'user_does_not_exist' => '无效用户，请重试。'
    ),

    'checkin' => array(
        'error'   		=> '资产还没有借入，请重试。',
        'success' 		=> '资产借入成功。',
        'user_does_not_exist' => '无效用户，请重试。'
    )

);
