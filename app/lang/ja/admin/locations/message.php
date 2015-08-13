<?php

return array(

    'does_not_exist' => 'ロケーションが存在しません。',
    'assoc_users'	 => 'ロケーションは少なくとも一つの利用者に関連付けされているため、削除できません。ローケーションの関連付けを削除し、もう一度試して下さい。 ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


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
