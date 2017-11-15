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
    'after_or_equal'       => ':attribute 必須在 :date 之後',
    'alpha'                => ':attribute 只能包含字母',
    'alpha_dash'           => ':attribute 只能包含字母，數字和\'-\'',
    'alpha_num'            => ':attribute 只允許字母和數字',
    'array'                => ':attribute 必須是陣列',
    'before'               => ':attribute 必須在 :date 之前',
    'before_or_equal'      => ':attribute 必須在 :date 之前',
    'between'              => [
        'numeric' => ':attribute 必須在 :min - :max 之間',
        'file'    => ':attribute 必須在 :min - :max KB 之間',
        'string'  => ':attribute 必須在 :min - :max 字元之間',
        'array'   => ':attribute 必須在 :min 和 :max 之間',
    ],
    'boolean'              => ':attribute 必須是 true 或 false',
    'confirmed'            => ':attribute 屬性不相符',
    'date'                 => ':attribute 不是有效日期',
    'date_format'          => ':attribute 不符合 :format 的格式',
    'different'            => ':attribute 和 :other 不能相同',
    'digits'               => ':attribute 必須是 :digits 數字',
    'digits_between'       => ':attribute 必須在 :min 和 :max 之间',
    'dimensions'           => ':attribute 屬性具有不正確圖像尺寸。',
    'distinct'             => ':attribute 具有重複值',
    'email'                => ':attribute 格式不正確',
    'exists'               => '選擇的 :attribute 無效',
    'file'                 => ':attribute 必須是檔案',
    'filled'               => ':attribute 欄位必須有值。',
    'image'                => ':attribute 必須是圖片格式',
    'in'                   => '選擇的 :attribute 無效',
    'in_array'             => ':attribute 屬性欄位不存在 :other。',
    'integer'              => ':attribute 必須是整數',
    'ip'                   => ':attribute 必須是有效 IP',
    'ipv4'                 => ':attribute 必須是有效的 IPv4 位址',
    'ipv6'                 => ':attribute 必須是有效的 IPv6 位址',
    'json'                 => ':attribute 必須是有效的 JSON 字串',
    'max'                  => [
        'numeric' => ':attribute 不可大於 :max',
        'file'    => ':attribute 不可大於 :max KB',
        'string'  => ':attribute 不可大於 :max 個字元',
        'array'   => ':attribute 不可大於 :max 個項目',
    ],
    'mimes'                => ':attribute 檔案類型必須是 :values',
    'mimetypes'            => ':attribute 檔案類型必須是 :values',
    'min'                  => [
        'numeric' => ':attribute 最少 :min',
        'file'    => ':attribute 最小 :min KB',
        'string'  => ':attribute 最少要有 :min 個字元',
        'array'   => ':attribute 最少要有 :min 個項目',
    ],
    'not_in'               => '選擇的 :attribute 無效',
    'numeric'              => ':attribute 必須是數字',
    'present'              => '：屬性字段必須存在。',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => ':attribute 格式不正確',
    'required'             => ':attribute 欄位必填',
    'required_if'          => ':attribute 欄位在 :other 是 :value 時是必填的',
    'required_unless'      => '需要：屬性字段，除非：other is in：values。',
    'required_with'        => '當設定 :value 時，:attribute 欄位必填',
    'required_with_all'    => '當：值存在時，需要：屬性字段。',
    'required_without'     => '當設定非 :value 時，:attribute 欄位必填',
    'required_without_all' => '當不存在：值時，需要：屬性字段。',
    'same'                 => ':attribute 和 :other 必需相符',
    'size'                 => [
        'numeric' => ':attribute 必須是 :size',
        'file'    => ':attribute 必須是 :size KB',
        'string'  => ':attribute 必須是 :size 個字元',
        'array'   => ':attribute 必須包含 :size 個項目',
    ],
    'string'               => ':attribute 必須是字串',
    'timezone'             => '：屬性必須是有效區域。',
    'unique'               => ':attribute 已被採用',
    'uploaded'             => ':attribute 上傳失敗',
    'url'                  => ':attribute 格式不正確',
    "unique_undeleted"     => ":attribute 必須是唯一值",

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
        'alpha_space' => ":attribute 含有無效字元",
        "email_array"      => "一個或多個郵件地址不正確",
        "hashed_pass"      => "當前密碼不正確！",
        'dumbpwd'          => '該密碼太常見。',
        "statuslabel_type" => "您必須選擇一個有效的狀態標籤",
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
