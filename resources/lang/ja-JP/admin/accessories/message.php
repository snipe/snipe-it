<?php

return array(

    'does_not_exist' => '付属品[:id]は存在しません。',
    'not_found' => 'その付属品は見つかりませんでした。',
    'assoc_users'	 => 'この付属品は、ユーザーに :count 個貸し出されています。もう一度、付属品を返却して下さい。 ',

    'create' => array(
        'error'   => '付属品は作成されていません。もう一度やり直してください。',
        'success' => '付属品は正常に作成されました。'
    ),

    'update' => array(
        'error'   => '付属品は更新されませんでした。もう一度、やり直して下さい。',
        'success' => '付属品は正常に更新されました。'
    ),

    'delete' => array(
        'confirm'   => 'この付属品を本当に削除してもよろしいですか？',
        'error'   => 'この付属品を削除する際に問題が発生しました。もう一度、やり直して下さい。',
        'success' => 'この付属品は正常に削除されました。'
    ),

     'checkout' => array(
        'error'   		=> '付属品がチェックされませんでした。もう一度、やり直して下さい。',
        'success' 		=> '付属品のチェックが終了しました。',
        'unavailable'   => '付属品はチェックアウト中のため利用できません。',
        'user_does_not_exist' => 'その利用者は不正です。もう一度、やり直して下さい。',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> '付属品がチェックされませんでした。もう一度、やり直して下さい。',
        'success' 		=> '付属品のチェックが終了しました。',
        'user_does_not_exist' => 'その利用者は不正です。もう一度、やり直して下さい。'
    )


);
