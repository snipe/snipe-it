<?php

return array(

    'does_not_exist' => '構成部品は存在しません',

    'create' => array(
        'error'   => '構成部品が作成できませんでした。もう一度やり直して下さい。',
        'success' => '構成部品が作成されました。'
    ),

    'update' => array(
        'error'   => '構成部品がが更新できませんでした。もう一度やり直して下さい。',
        'success' => '構成部品が作成されました。'
    ),

    'delete' => array(
        'confirm'   => 'この構成部品を削除してもよろしいですか?',
        'error'   => '構成部品を削除する際に問題が発生しました。もう一度やり直して下さい。',
        'success' => '構成部品は削除されました。',
        'error_qty'   => 'Some components of this type are still checked out. Please check them in and try again.',
    ),

     'checkout' => array(
        'error'   		=> '構成部品はチェックアウトされませんでした。もう一度、やり直して下さい。',
        'success' 		=> '構成部品は正常にチェックアウトされました。',
        'user_does_not_exist' => '利用者が正しくありません。もう一度試して下さい。',
        'unavailable'      => '残りのコンポーネントが不足しています: :remaining, :requested ',
    ),

    'checkin' => array(
        'error'   		=> '構成部品はチェックインされませんでした。もう一度、やり直して下さい。',
        'success' 		=> '構成部品は正常にチェックインされました。',
        'user_does_not_exist' => '利用者が正しくありません。もう一度試して下さい。'
    )


);
