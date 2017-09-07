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
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute は、文字が含まれている必要があります。',
    'alpha_dash'           => ':attribute は、文字列、数字、ダッシュ（−）のみ含めることが出来ます。',
    'alpha_num'            => ':attribute は、文字列と数字のみ含めることが出来ます。',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute は :date よりも前の日付にして下さい。',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute は :min - :max の範囲内にして下さい。',
        'file'    => ':attribute は :min - :max キロバイトの範囲内にして下さい。',
        'string'  => ':attribute は :min - :max 文字の範囲内にして下さい。',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute は、 true もしくは false にしてください。',
    'confirmed'            => ':attribute が、一致しませんでした。',
    'date'                 => ':attribute は、無効な日付です。',
    'date_format'          => ':attribute フォーマット :format に一致しません。',
    'different'            => ':attribute と :other は、異なっている必要があります。',
    'digits'               => ':attribute は :digits 数値にして下さい。',
    'digits_between'       => ':attribute は :min - :max 内の数値にして下さい。',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute フォーマットが不正です。',
    'exists'               => '選択された :attribute は不正です。',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute は画像にして下さい。',
    'in'                   => '選択された :attribute は不正です。',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute は整数にして下さい。',
    'ip'                   => ':attribute は有効なIPアドレスにして下さい。',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute は :max 以上にして下さい。',
        'file'    => ':attribute は :max キロバイト以上にして下さい。',
        'string'  => ':attribute は :max 文字以上にして下さい。',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute は ファイルタイプ :values にして下さい。',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute は、少なくとも :min 以上にして下さい。',
        'file'    => ':attribute は、少なくとも :min キロバイト以上にして下さい。',
        'string'  => ':attribute は、少なくとも :min 文字以上にして下さい。',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => '選択された :attribute は不正です。',
    'numeric'              => ':attribute は数字にして下さい。',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute フォーマットが不正です。',
    'required'             => ':attribute フィールドは、必須です。',
    'required_if'          => ':other が :value の時、:attribute フィールドは必須です。',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':value が存在する場合、:attribute フィールドは必須です。',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':value が存在しな場合、:attribute フィールドは必須です。',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute と :other は、一致しなければなりません。',
    'size'                 => [
        'numeric' => ':attribute は :size にして下さい。',
        'file'    => ':attribute は :size キロバイトにして下さい。',
        'string'  => ':attribute は :size 文字にして下さい。',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute は、取得済みです。',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute フォーマットが不正です。',

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
        'alpha_space' => "The :attribute field contains a character that is not allowed.",
        "email_array"      => "One or more email addresses is invalid.",
        "hashed_pass"      => "Your current password is incorrect",
        'dumbpwd'          => 'That password is too common.',
        "statuslabel_type" => "You must select a valid status label type",
        "unique_undeleted" => "The :attribute must be unique.",
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
