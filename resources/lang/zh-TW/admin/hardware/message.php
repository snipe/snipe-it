<?php

return [

    'undeployable' 		=> '<strong>警告: </strong>此資產目前已標記為不可佈署，如果資產狀態已改變，請更新狀態。',
    'does_not_exist' 	=> '資產不存在',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> '此資產目前已借給某個使用者，不能被刪除，請檢查資產狀態，然後再嘗試刪除。',

    'create' => [
        'error'   		=> '新增資產失敗，請重試。',
        'success' 		=> '新增資產成功。',
    ],

    'update' => [
        'error'   			=> '更新資產失敗，請重試。',
        'success' 			=> '更新資產成功。',
        'nothing_updated'	=>  '沒有欄位被選擇，因此沒有更新任何內容。',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> '恢復資產失敗，請重試。',
        'success' 		=> '恢復資產成功。',
    ],

    'audit' => [
        'error'   		=> '資產稽核失敗。請再試一次。',
        'success' 		=> '資產稽核成功登錄。',
    ],


    'deletefile' => [
        'error'   => '刪除檔案失敗，請重試。',
        'success' => '刪除檔案成功。',
    ],

    'upload' => [
        'error'   => '上傳檔案失敗，請重試。',
        'success' => '上傳檔案成功。',
        'nofiles' => '您尚未選擇要上傳的檔案，或上傳的檔案太大。',
        'invalidfiles' => '一個或多個檔案太大或屬於不被允許的檔案類型。允許上傳的檔案類型：png, gif, jpg, doc, docx, pdf, txt。',
    ],

    'import' => [
        'error'                 => '某些項目沒有被正確匯入。',
        'errorDetail'           => '以下項目由於錯誤未被匯入。',
        'success'               => '您的檔案已被匯入。',
        'file_delete_success'   => '您的檔案已成功刪除。',
        'file_delete_error'      => '您的檔案無法被刪除。',
    ],


    'delete' => [
        'confirm'   	=> '您確定要刪除此資產嗎？',
        'error'   		=> '刪除資產時發生問題，請重試。',
        'nothing_updated'   => '沒有資產被選擇，因此沒有更新任何內容。',
        'success' 		=> '刪除資產成功。',
    ],

    'checkout' => [
        'error'   		=> '借出資產失敗，請重試。',
        'success' 		=> '借出資產成功。',
        'user_does_not_exist' => '無效使用者，請重試。',
        'not_available' => '此資產無法借出',
        'no_assets_selected' => '你必須至少選擇一項資產。',
    ],

    'checkin' => [
        'error'   		=> '繳回資產失敗，請重試。',
        'success' 		=> '繳回資產成功。',
        'user_does_not_exist' => '無效使用者，請重試。',
        'already_checked_in'  => '資產已繳回。',

    ],

    'requests' => [
        'error'   		=> '申請資產失敗，請重試。',
        'success' 		=> '申請資產成功。',
        'canceled'      => '借出申請已取消。',
    ],

];
