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

    "accepted"         => " :attribute 必须接受",
    "active_url"       => ":attribute 不是正确的网址",
    "after"            => " :attribute 必须在 :date 之后",
    "alpha"            => ":attribute 只能包含字母",
    "alpha_dash"       => ":attribute 只能包含字母，数字和'-'",
    "alpha_num"        => ":attribute 只允许字母和数字",
    "before"           => ":attribute 必须在 :date 之前",
    "between"          => array(
        "numeric" => ":attribute 必须在 :min - :max 之间",
        "file"    => ":attribute 必须在 :min - :max kb 之间",
        "string"  => ":attribute 必须在 :min - :max 字符之间",
    ),
    "confirmed"        => ":attribute 属性不匹配",
    "date"             => ":attribute 不是有效日期",
    "date_format"      => ":attribute 不符合 :format 的格式",
    "different"        => " :attribute 和 :other 不能相同",
    "digits"           => ":attribute 必须是  :digits  数字",
    "digits_between"   => ":attribute 必须在 :min 和 :max 数字之间",
    "email"            => ":attribute 格式不对",
    "exists"           => "选择的 :attribute 无效",
    "email_array"      => "一个或多个邮件地址不正确",
    "image"            => ":attribute 必须是图片格式",
    "in"               => "选择的 :attribute 无效",
    "integer"          => ":attribute 必须是整数",
    "ip"               => ":attribute 必须是有效IP",
    "max"              => array(
        "numeric" => ":attribute 不大于 :max",
        "file"    => ":attribute 不大于 :max kb",
        "string"  => ":attribute 不大于 :max 字符",
    ),
    "mimes"            => ":attribute 文件类型必须是 :values",
    "min"              => array(
        "numeric" => ":attribute 最少  :min",
        "file"    => ":attribute 最小 :min kb",
        "string"  => ":attribute 最少 :min个字符",
    ),
    "not_in"           => "选择的 :attribute 无效",
    "numeric"          => ":attribute 必须是数字",
    "regex"            => ":attribute 格式不对",
    "required"         => ":attribute 字段必填",
    "required_if"      => ":attribute 字段在 :other 是 :value 时是必须的",
    "required_with"    => " 当:values 是现在 :attribute 是必需的",
    "required_without" => "当:values 是现在 :attribute 是必需的",
    "same"             => ":attribute 和 :other  必需匹配",
    "size"             => array(
        "numeric" => ":attribute 必需是  :size",
        "file"    => ":attribute 必需是 :size kb",
        "string"  => ":attribute 必需是 :size 个字符",
    ),
    "unique"           => ":attribute 已经被采用",
    "url"              => ":attribute 格式无效",
    "statuslabel_type" => "你必须选择一个有效的状态标签类型",
    "unique_undeleted" => " :attribute 必须唯一",


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
    'alpha_space' => ":attribute 含有无效字符",

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
