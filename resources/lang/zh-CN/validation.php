<?php

return [

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
    'after_or_equal'       => 'the：属性必须是以下或之后的日期：date。',
    'alpha'                => ':attribute 只能包含字母',
    'alpha_dash'           => ':attribute 只能包含字母，数字和\'-\'',
    'alpha_num'            => ':attribute 只允许字母和数字',
    'array'                => '：属性必须是数组。',
    'before'               => ':attribute 必须在 :date 之前',
    'before_or_equal'      => '：属性必须是之前或之前的日期：date。',
    'between'              => [
        'numeric' => ':attribute 必须在 :min - :max 之间',
        'file'    => ':attribute 必须在 :min - :max kb 之间',
        'string'  => ':attribute 必须在 :min - :max 字符之间',
        'array'   => 'the：属性必须有：min和：max items之间。',
    ],
    'boolean'              => '：属性字段必须为true或false。',
    'confirmed'            => ':attribute 属性不匹配',
    'date'                 => ':attribute 不是有效日期',
    'date_format'          => ':attribute 不符合 :format 的格式',
    'different'            => ' :attribute 和 :other 不能相同',
    'digits'               => ':attribute 必须是  :digits  数字',
    'digits_between'       => ':attribute 必须在 :min 和 :max 数字之间',
    'dimensions'           => 'the：属性具有无效的图像尺寸。',
    'distinct'             => '：属性字段具有重复值。',
    'email'                => ':attribute 格式不对',
    'exists'               => '选择的 :attribute 无效',
    'file'                 => '：属性必须是一个文件。',
    'filled'               => '：属性字段必须有一个值。',
    'image'                => ':attribute 必须是图片格式',
    'import_field_empty'    => ':fieldname 的值不能为空。',
    'in'                   => '选择的 :attribute 无效',
    'in_array'             => '：属性字段不存在于：其他。',
    'integer'              => ':attribute 必须是整数',
    'ip'                   => ':attribute 必须是有效IP',
    'ipv4'                 => '：属性必须是有效的IPv4地址。',
    'ipv6'                 => '：属性必须是有效的IPv6地址。',
    'is_unique_department' => ':attribute 必须是唯一的公司地理位置',
    'json'                 => '：属性必须是有效的JSON字符串。',
    'max'                  => [
        'numeric' => ':attribute 不大于 :max',
        'file'    => ':attribute 不大于 :max kb',
        'string'  => ':attribute 不大于 :max 字符',
        'array'   => '：属性可能不超过：max项。',
    ],
    'mimes'                => ':attribute 文件类型必须是 :values',
    'mimetypes'            => '：属性必须是一个类型为：的值的文件。',
    'min'                  => [
        'numeric' => ':attribute 最少  :min',
        'file'    => ':attribute 最小 :min kb',
        'string'  => ':attribute 最少 :min个字符',
        'array'   => '：属性必须至少有：最小项。',
    ],
    'starts_with'          => ':attribute 必须以以下一个开始：:values',
    'ends_with'            => ':attribute 必须以: :values 其中一个结尾。',

    'not_in'               => '选择的 :attribute 无效',
    'numeric'              => ':attribute 必须是数字',
    'present'              => '：属性字段必须存在。',
    'valid_regex'          => '这不是一个有效的正则表达式。 ',
    'regex'                => ':attribute 格式不对',
    'required'             => ':attribute 字段必填',
    'required_if'          => ':attribute 字段在 :other 是 :value 时是必须的',
    'required_unless'      => '需要：属性字段，除非：other is in：values。',
    'required_with'        => ' 当:values 是现在 :attribute 是必需的',
    'required_with_all'    => '当：值存在时，需要：属性字段。',
    'required_without'     => '当:values 是现在 :attribute 是必需的',
    'required_without_all' => '当不存在：值时，需要：属性字段。',
    'same'                 => ':attribute 和 :other  必需匹配',
    'size'                 => [
        'numeric' => ':attribute 必需是  :size',
        'file'    => ':attribute 必需是 :size kb',
        'string'  => ':attribute 必需是 :size 个字符',
        'array'   => '：属性必须包含：size项。',
    ],
    'string'               => '：属性必须是字符串。',
    'timezone'             => '：属性必须是有效区域。',
    'unique'               => ':attribute 已经被采用',
    'uploaded'             => '：属性无法上传。',
    'url'                  => ':attribute 格式无效',
    'unique_undeleted'     => ':attribute 属性必须唯一。',
    'non_circular'         => ':attribute 不能创建循环引用。',
    'disallow_same_pwd_as_user_fields' => '密码不能和用户名相同。',
    'letters'              => '密码必须包含至少一个字母。',
    'numbers'              => '密码必须包含至少一个数字。',
    'case_diff'            => '密码必须使用混合大小写。',
    'symbols'              => '密码必须包含符号。',
    'gte'                  => [
        'numeric'          => '数值不能为负数'
    ],


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
        'alpha_space' => '：属性字段包含不允许的字符。',
        'email_array'      => '一个或多个电子邮件地址无效。',
        'hashed_pass'      => '您当前的密码不正确',
        'dumbpwd'          => '那个密码太常见了。',
        'statuslabel_type' => '您必须选择有效的状态标签类型',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute 必须是 YYYY-MM-DD 格式的有效日期',
        'last_audit_date.date_format'   =>  ':attribute 必须是 YYYY-MM-DD hh:mm:ss 格式的有效日期',
        'expiration_date.date_format'   =>  ':attribute 必须是 YYYY-MM-DD 格式的有效日期',
        'termination_date.date_format'  =>  ':attribute 必须是 YYYY-MM-DD 格式的有效日期',
        'expected_checkin.date_format'  =>  ':attribute 必须是 YYYY-MM-DD 格式的有效日期',
        'start_date.date_format'        =>  ':attribute 必须是 YYYY-MM-DD 格式的有效日期',
        'end_date.date_format'          =>  ':attribute 必须是 YYYY-MM-DD 格式的有效日期',

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

];
