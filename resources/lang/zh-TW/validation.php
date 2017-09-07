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

    'accepted'             => ':attribute 必須接受',
    'active_url'           => '屬性不是有效的URL',
    'after'                => ':attribute 必須在 :date 之後',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute 只能包含字母',
    'alpha_dash'           => ':attribute 只能包含字母，數字和\'-\'',
    'alpha_num'            => ':attribute 只允許字母和數字',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute 必須在 :date 之前',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute 必須在 :min - :max 之間',
        'file'    => ':attribute 必須在 :min - :max KB 之間',
        'string'  => ':attribute 必須在 :min - :max 字元之間',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute 必須是 true 或 false',
    'confirmed'            => ':attribute 屬性不相符',
    'date'                 => ':attribute 不是有效日期',
    'date_format'          => ':attribute 不符合 :format 的格式',
    'different'            => ':attribute 和 :other 不能相同',
    'digits'               => ':attribute 必須是 :digits 數字',
    'digits_between'       => ':attribute 必須在 :min 和 :max 之间',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute 格式不正確',
    'exists'               => '選擇的 :attribute 無效',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute 必須是圖片格式',
    'in'                   => '選擇的 :attribute 無效',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute 必須是整數',
    'ip'                   => ':attribute 必須是有效 IP',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute 不可大於 :max',
        'file'    => ':attribute 不可大於 :max KB',
        'string'  => ':attribute 不可大於 :max 個字元',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute 檔案類型必須是 :values',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 最少 :min',
        'file'    => ':attribute 最小 :min KB',
        'string'  => ':attribute 最少要有 :min 個字元',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => '選擇的 :attribute 無效',
    'numeric'              => ':attribute 必須是數字',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute 格式不正確',
    'required'             => ':attribute 欄位必填',
    'required_if'          => ':attribute 欄位在 :other 是 :value 時是必填的',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => '當設定 :value 時，:attribute 欄位必填',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => '當設定非 :value 時，:attribute 欄位必填',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute 和 :other 必需相符',
    'size'                 => [
        'numeric' => ':attribute 必須是 :size',
        'file'    => ':attribute 必須是 :size KB',
        'string'  => ':attribute 必須是 :size 個字元',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute 已被採用',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute 格式不正確',

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
