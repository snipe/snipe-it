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

    'accepted'             => ' :attribute 必须接受',
    'active_url'           => ':attribute 不是正确的网址',
    'after'                => ' :attribute 必须在 :date 之后',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute 只能包含字母',
    'alpha_dash'           => ':attribute 只能包含字母，数字和\'-\'',
    'alpha_num'            => ':attribute 只允许字母和数字',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute 必须在 :date 之前',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute 必须在 :min - :max 之间',
        'file'    => ':attribute 必须在 :min - :max kb 之间',
        'string'  => ':attribute 必须在 :min - :max 字符之间',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute 属性不匹配',
    'date'                 => ':attribute 不是有效日期',
    'date_format'          => ':attribute 不符合 :format 的格式',
    'different'            => ' :attribute 和 :other 不能相同',
    'digits'               => ':attribute 必须是  :digits  数字',
    'digits_between'       => ':attribute 必须在 :min 和 :max 数字之间',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute 格式不对',
    'exists'               => '选择的 :attribute 无效',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute 必须是图片格式',
    'in'                   => '选择的 :attribute 无效',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute 必须是整数',
    'ip'                   => ':attribute 必须是有效IP',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute 不大于 :max',
        'file'    => ':attribute 不大于 :max kb',
        'string'  => ':attribute 不大于 :max 字符',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute 文件类型必须是 :values',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 最少  :min',
        'file'    => ':attribute 最小 :min kb',
        'string'  => ':attribute 最少 :min个字符',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => '选择的 :attribute 无效',
    'numeric'              => ':attribute 必须是数字',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute 格式不对',
    'required'             => ':attribute 字段必填',
    'required_if'          => ':attribute 字段在 :other 是 :value 时是必须的',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ' 当:values 是现在 :attribute 是必需的',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => '当:values 是现在 :attribute 是必需的',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute 和 :other  必需匹配',
    'size'                 => [
        'numeric' => ':attribute 必需是  :size',
        'file'    => ':attribute 必需是 :size kb',
        'string'  => ':attribute 必需是 :size 个字符',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute 已经被采用',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute 格式无效',

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
