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

    "accepted"         => ":attribute は、承認される必要があります。",
    "active_url"       => ":attribute は、有効なURLではありません。",
    "after"            => ":attribute は :date よりも後の日付にして下さい。",
    "alpha"            => ":attribute は、文字が含まれている必要があります。",
    "alpha_dash"       => ":attribute は、文字列、数字、ダッシュ（−）のみ含めることが出来ます。",
    "alpha_num"        => ":attribute は、文字列と数字のみ含めることが出来ます。",
    "before"           => ":attribute は :date よりも前の日付にして下さい。",
    "between"          => array(
        "numeric" => ":attribute は :min - :max の範囲内にして下さい。",
        "file"    => ":attribute は :min - :max キロバイトの範囲内にして下さい。",
        "string"  => ":attribute は :min - :max 文字の範囲内にして下さい。",
    ),
    "confirmed"        => ":attribute が、一致しませんでした。",
    "date"             => ":attribute は、無効な日付です。",
    "date_format"      => ":attribute フォーマット :format に一致しません。",
    "different"        => ":attribute と :other は、異なっている必要があります。",
    "digits"           => ":attribute は :digits 数値にして下さい。",
    "digits_between"   => ":attribute は :min - :max 内の数値にして下さい。",
    "email"            => ":attribute フォーマットが不正です。",
    "exists"           => "選択された :attribute は不正です。",
    "email_array"      => "指定の電子メールアドレスは無効です。",
    "image"            => ":attribute は画像にして下さい。",
    "in"               => "選択された :attribute は不正です。",
    "integer"          => ":attribute は整数にして下さい。",
    "ip"               => ":attribute は有効なIPアドレスにして下さい。",
    "max"              => array(
        "numeric" => ":attribute は :max 以上にして下さい。",
        "file"    => ":attribute は :max キロバイト以上にして下さい。",
        "string"  => ":attribute は :max 文字以上にして下さい。",
    ),
    "mimes"            => ":attribute は ファイルタイプ :values にして下さい。",
    "min"              => array(
        "numeric" => ":attribute は、少なくとも :min 以上にして下さい。",
        "file"    => ":attribute は、少なくとも :min キロバイト以上にして下さい。",
        "string"  => ":attribute は、少なくとも :min 文字以上にして下さい。",
    ),
    "not_in"           => "選択された :attribute は不正です。",
    "numeric"          => ":attribute は数字にして下さい。",
    "regex"            => ":attribute フォーマットが不正です。",
    "required"         => ":attribute フィールドは、必須です。",
    "required_if"      => ":other が :value の時、:attribute フィールドは必須です。",
    "required_with"    => ":value が存在する場合、:attribute フィールドは必須です。",
    "required_without" => ":value が存在しな場合、:attribute フィールドは必須です。",
    "same"             => ":attribute と :other は、一致しなければなりません。",
    "size"             => array(
        "numeric" => ":attribute は :size にして下さい。",
        "file"    => ":attribute は :size キロバイトにして下さい。",
        "string"  => ":attribute は :size 文字にして下さい。",
    ),
    "unique"           => ":attribute は、取得済みです。",
    "url"              => ":attribute フォーマットが不正です。",
    "statuslabel_type" => "有効なステータス ラベルの種類を選択する必要があります。",
    "unique_undeleted" => ":attribute は 一意の値である必要があります。",


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

    'custom' => array(),
    'alpha_space' => ":attribute フィールドに、禁止文字列が含まれています。",

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

    'attributes' => array(),

);
