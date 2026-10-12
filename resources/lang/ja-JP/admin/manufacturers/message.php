<?php

return [

    'support_url_help' => 'URL内で<code>{LOCALE}</code>、<code>{SERIAL}</code>、<code>{MODEL_NUMBER}</code>、<code>{MODEL_NAME}</code>を使用すると、資産の表示時に各値へ自動置換できます。例: https://checkcoverage.apple.com/{LOCALE}/{SERIAL}',
    'does_not_exist' => '製造元が存在しません。',
    'assoc_users' => 'この製造元は一つ以上の型番に関連付けられているため、削除できません。この製造元の関連付けを削除後、もう一度試して下さい。 ',

    'create' => [
        'error' => '製造元が作成できませんでした。もう一度試して下さい。',
        'success' => '製造元が作成されました。',
    ],

    'update' => [
        'error' => '製造元が更新できませんでした。もう一度試して下さい。',
        'success' => '製造元が更新できませんでした。もう一度試して下さい。',
    ],

    'restore' => [
        'error' => '製造元が復元できませんでした。もう一度試して下さい。',
        'success' => '製造元が復元されました。',
    ],

    'delete' => [
        'confirm' => '本当にこの製造元を削除しますか？',
        'error' => '製造元を削除する際に問題が発生しました。もう一度試して下さい。',
        'success' => '製造元を削除しました。',
        'bulk_success' => '製造元を削除しました。|製造元を:count件削除しました。',
        'partial_success' => '製造元を削除しました。詳しくは以下をご確認ください。|製造元を:count件削除しました。詳しくは以下をご確認ください。',
    ],

];
