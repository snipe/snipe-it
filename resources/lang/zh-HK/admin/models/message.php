<?php

return array(

    'does_not_exist' => '樣板不存在',
    'assoc_users'	 => '至少還有一個資產與此樣板關聯，目前不能被删除，請在刪除資產後重試。 ',


    'create' => array(
        'error'   => '新增樣板失敗，請重試。',
        'success' => '新增樣板成功。',
        'duplicate_set' => '資產名稱、製造商、型號都相同的其它資產樣板已存在。',
    ),

    'update' => array(
        'error'   => '更新樣板失敗，請重試。',
        'success' => '更新樣板成功。'
    ),

    'delete' => array(
        'confirm'   => '您確定要刪除此樣板嗎？',
        'error'   => '刪除樣板失敗，請重試。',
        'success' => '刪除樣板成功。'
    ),

    'restore' => array(
        'error'   		=> '恢復樣板失敗，請重試。',
        'success' 		=> '恢復樣板成功。'
    ),

    'bulkedit' => array(
        'error'   		=> '沒有欄位被更改，因此沒有更新任何內容。',
        'success' 		=> '樣板已更新。'
    ),

    'bulkdelete' => array(
        'error'   		    => '沒有型號被選擇，因此沒有更新任何內容。',
        'success' 		    => ':success_count 個型號已刪除!',
        'success_partial' 	=> ':success_count 個型號被刪除, 但是 :fail_count 無法被刪除, 因為它們仍有與之關聯的資產。'
    ),

);
