<?php

return array(

    'does_not_exist' => 'ロケーションが存在しません。',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'この設置場所は1人以上の利用者に関連付けされているため、削除できません。設置場所の関連付けを削除し、もう一度試して下さい。 ',
    'assoc_child_loc'	 => 'この設置場所は、少なくとも一つの配下の設置場所があります。この設置場所を参照しないよう更新して下さい。 ',
    'assigned_assets' => '割り当て済みアセット',
    'current_location' => '現在の場所',


    'create' => array(
        'error'   => 'ロケーションが作成できませんでした。もう一度やり直して下さい。',
        'success' => 'ロケーションが作成されました。'
    ),

    'update' => array(
        'error'   => 'ロケーションが更新できませんでした。もう一度やり直して下さい。',
        'success' => 'ロケーションが更新されました。'
    ),

    'delete' => array(
        'confirm'   	=> 'このロケーションを本当に削除してよいですか？',
        'error'   => 'ロケーションを削除する際に問題が発生しました。もう一度やり直して下さい。',
        'success' => 'ロケーションが削除されました。'
    )

);
