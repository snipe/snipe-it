<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute は、承認される必要があります。',
    'active_url'           => ':attribute は、有効なURLではありません。',
    'after'                => ':attribute は :date よりも後の日付にして下さい。',
    'after_or_equal'       => ':attribute は :date よりも後の日付か同じ日にして下さい。',
    'alpha'                => ':attribute は、文字が含まれている必要があります。',
    'alpha_dash'           => ':attribute は、文字列、数字、ダッシュ（−）のみ含めることが出来ます。',
    'alpha_num'            => ':attribute は、文字列と数字のみ含めることが出来ます。',
    'array'                => ':attribute は配列にして下さい。',
    'before'               => ':attribute は :date よりも前の日付にして下さい。',
    'before_or_equal'      => ':attribute は :date よりも前の日付か同じ日にして下さい。',
    'between'              => [
        'numeric' => ':attribute は :min - :max の範囲内にして下さい。',
        'file'    => ':attribute は :min - :max キロバイトの範囲内にして下さい。',
        'string'  => ':attribute は :min - :max 文字の範囲内にして下さい。',
        'array'   => ':attribute は :min ～ :max 内の数値にして下さい。',
    ],
    'boolean'              => ':attribute は、 true もしくは false にしてください。',
    'confirmed'            => ':attribute が、一致しませんでした。',
    'date'                 => ':attribute は、無効な日付です。',
    'date_format'          => ':attribute フォーマット :format に一致しません。',
    'different'            => ':attribute と :other は、異なっている必要があります。',
    'digits'               => ':attribute は :digits 数値にして下さい。',
    'digits_between'       => ':attribute は :min - :max 内の数値にして下さい。',
    'dimensions'           => ':attribute に無効な画像サイズがあります。',
    'distinct'             => ':attribute フィールドに重複する値があります。',
    'email'                => ':attribute フォーマットが不正です。',
    'exists'               => '選択された :attribute は不正です。',
    'file'                 => ':attribute はファイルにして下さい。',
    'filled'               => ':attribute フィールドは空に出来ません。',
    'image'                => ':attribute は画像にして下さい。',
    'in'                   => '選択された :attribute は不正です。',
    'in_array'             => ':attribute フィールドが :other に存在しません。',
    'integer'              => ':attribute は整数にして下さい。',
    'ip'                   => ':attribute は有効なIPアドレスにして下さい。',
    'ipv4'                 => ':attribute は有効なIPアドレスにして下さい。',
    'ipv6'                 => ':attribute は有効なIPv6アドレスにして下さい。',
    'json'                 => ':attribute は有効なJSON文字列にして下さい。',
    'max'                  => [
        'numeric' => ':attribute は :max 以上にして下さい。',
        'file'    => ':attribute は :max キロバイト以上にして下さい。',
        'string'  => ':attribute は :max 文字以上にして下さい。',
        'array'   => ':attribute は :max 以上のアイテムを持つことは出来ません。',
    ],
    'mimes'                => ':attribute は ファイルタイプ :values にして下さい。',
    'mimetypes'            => ':attribute はファイルタイプ :values にして下さい。',
    'min'                  => [
        'numeric' => ':attribute は、少なくとも :min 以上にして下さい。',
        'file'    => ':attribute は、少なくとも :min キロバイト以上にして下さい。',
        'string'  => ':attribute は、少なくとも :min 文字以上にして下さい。',
        'array'   => ':attribute は少なくとも :min 以上にして下さい。',
    ],
    'not_in'               => '選択された :attribute は不正です。',
    'numeric'              => ':attribute は数字にして下さい。',
    'present'              => ':attribute フィールドは必須です。',
    'valid_regex'          => '有効な正規表現ではありません。',
    'regex'                => ':attribute フォーマットが不正です。',
    'required'             => ':attribute フィールドは、必須です。',
    'required_if'          => ':other が :value の時、:attribute フィールドは必須です。',
    'required_unless'      => ':other が :value の時でなければ、:attribute フィールドは必須です。',
    'required_with'        => ':value が存在する場合、:attribute フィールドは必須です。',
    'required_with_all'    => ':value が存在する場合、:attribute フィールドは必須です。',
    'required_without'     => ':value が存在しな場合、:attribute フィールドは必須です。',
    'required_without_all' => ':value が存在しない場合、:attribute フィールドは必須です。',
    'same'                 => ':attribute と :other は、一致しなければなりません。',
    'size'                 => [
        'numeric' => ':attribute は :size にして下さい。',
        'file'    => ':attribute は :size キロバイトにして下さい。',
        'string'  => ':attribute は :size 文字にして下さい。',
        'array'   => ':attribute には、 :size が含まれていなければなりません。',
    ],
    'string'               => ':attribute は文字列にして下さい。',
    'timezone'             => ':attribute は有効なゾーンにして下さい。',
    'unique'               => ':attribute は、取得済みです。',
    'uploaded'             => ':attribute のアップロードに失敗しました。',
    'url'                  => ':attribute フォーマットが不正です。',
    "unique_undeleted"     => ":attribute は 一意の値である必要があります。",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'alpha_space' => ":attribute フィールドに、禁止文字列が含まれています。",
        "email_array"      => "1 つまたは複数の電子メール アドレスが無効です。",
        "hashed_pass"      => "現在のパスワードが正しくありません。",
        'dumbpwd'          => 'そのパスワードはあまりにも脆弱です。',
        "statuslabel_type" => "有効なステータスラベルの種類を選択する必要があります。",
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

);
