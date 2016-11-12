<?php

return array(

<<<<<<< HEAD
    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Asset does not exist.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

    'create' => array(
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Asset created successfully. :)'
    ),

    'update' => array(
        'error'   			=> 'Asset was not updated, please try again',
        'success' 			=> 'Asset updated successfully.',
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
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'import' => array(
        'error'         => 'Some items did not import correctly.',
        'errorDetail'   => 'The following Items were not imported because of errors.',
        'success'       => "Your file has been imported",
=======
    'undeployable' 		=> '<strong>警告: </strong>此資產目前已標記為不可佈署，如果資產狀態已改變，請更新狀態。',
    'does_not_exist' 	=> '資產不存在',
    'does_not_exist_or_not_requestable' => '已重試。該資產不存在或不可申領。',
    'assoc_users'	 	=> '此資產目前已借給某個使用者，不能被刪除，請檢查資產狀態，然後再嘗試刪除。',

    'create' => array(
        'error'   		=> '新增資產失敗，請重試。',
        'success' 		=> '新增資產成功。'
    ),

    'update' => array(
        'error'   			=> '更新資產失敗，請重試。',
        'success' 			=> '更新資產成功。',
        'nothing_updated'	=>  '沒有欄位被選擇，因此沒有更新任何內容。',
    ),

    'restore' => array(
        'error'   		=> '恢復資產失敗，請重試。',
        'success' 		=> '恢復資產成功。'
    ),

    'deletefile' => array(
        'error'   => '刪除檔案失敗，請重試。',
        'success' => '刪除檔案成功。',
    ),

    'upload' => array(
        'error'   => '上傳檔案失敗，請重試。',
        'success' => '上傳檔案成功。',
        'nofiles' => '您尚未選擇要上傳的檔案，或上傳的檔案太大。',
        'invalidfiles' => '一個或多個檔案太大或屬於不被允許的檔案類型。允許上傳的檔案類型：png, gif, jpg, doc, docx, pdf, txt。',
    ),

    'import' => array(
        'error'                 => '某些項目沒有被正確匯入。',
        'errorDetail'           => '以下項目由於錯誤未被匯入。',
        'success'               => "您的檔案已被匯入。",
        'file_delete_success'   => "您的檔案已成功刪除。",
        'file_delete_error'      => "您的檔案無法被刪除。",
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),


    'delete' => array(
<<<<<<< HEAD
        'confirm'   	=> 'Are you sure you wish to delete this asset?',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'success' 		=> 'The asset was deleted successfully.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'already_checked_in'  => 'That asset is already checked in.',
=======
        'confirm'   	=> '您確定要刪除此資產嗎？',
        'error'   		=> '刪除資產時發生問題，請重試。',
        'success' 		=> '刪除資產成功。'
    ),

    'checkout' => array(
        'error'   		=> '借出資產失敗，請重試。',
        'success' 		=> '借出資產成功。',
        'user_does_not_exist' => '無效使用者，請重試。',
        'not_available' => '此資產無法借出'
    ),

    'checkin' => array(
        'error'   		=> '繳回資產失敗，請重試。',
        'success' 		=> '繳回資產成功。',
        'user_does_not_exist' => '無效使用者，請重試。',
        'already_checked_in'  => '資產已繳回。',
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

    ),

    'requests' => array(
<<<<<<< HEAD
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
=======
        'error'   		=> '申請資產失敗，請重試。',
        'success' 		=> '申請資產成功。',
        'canceled'      => '借出申請已取消。'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    )

);
