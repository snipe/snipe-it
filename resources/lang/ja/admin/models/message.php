<?php

return array(

    'does_not_exist' => '型番が存在しません。',
    'assoc_users'	 => 'この型番は他の資産に関連付けられているため、削除できません。資産を削除してから、もう一度試して下さい。 ',


    'create' => array(
        'error'   => '型番が作成できませんでした。もう一度やり直して下さい。',
        'success' => '型番が作成されました。',
        'duplicate_set' => '資産型の名前や製造元、型番は、既に存在してます。',
    ),

    'update' => array(
        'error'   => '型番が更新できませんでした。もう一度やり直して下さい。',
        'success' => '型番が更新されました。'
    ),

    'delete' => array(
        'confirm'   => '本当にこの資産の型番を削除しますか？',
        'error'   => '型番を削除する際に問題が発生しました。もう一度やり直して下さい。',
        'success' => '型番は削除されました。'
    ),

    'restore' => array(
        'error'   		=> '型番が復元されませんでした。もう一度、やり直して下さい。',
        'success' 		=> '型番は復元されました。'
    ),

    'bulkedit' => array(
        'error'   		=> 'フィールドが選択されていないため、更新されませんでした。',
        'success' 		=> '型番を更新しました。'
    ),

    'bulkdelete' => array(
        'error'   		    => 'モデルが選択されていないため、何も削除されませんでした。',
        'success' 		    => ':success_count モデルが削除されました！',
        'success_partial' 	=> ':success_count モデルが削除されましたが、:fail_count 個はアセットが関連付けられているため、削除できませんでした。'
    ),

);
