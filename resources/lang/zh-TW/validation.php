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

<<<<<<< HEAD
    "accepted"         => "The :attribute must be accepted.",
    "active_url"       => "屬性不是有效的URL",
    "after"            => "The :attribute must be a date after :date.",
    "alpha"            => "The :attribute may only contain letters.",
    "alpha_dash"       => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num"        => "The :attribute may only contain letters and numbers.",
    "before"           => "The :attribute must be a date before :date.",
    "between"          => array(
        "numeric" => "The :attribute must be between :min - :max.",
        "file"    => "The :attribute must be between :min - :max kilobytes.",
        "string"  => "The :attribute must be between :min - :max characters.",
    ),
    "confirmed"        => "The :attribute confirmation does not match.",
    "date"             => "The :attribute is not a valid date.",
    "date_format"      => "The :attribute does not match the format :format.",
    "different"        => "The :attribute and :other must be different.",
    "digits"           => "The :attribute must be :digits digits.",
    "digits_between"   => "The :attribute must be between :min and :max digits.",
    "email"            => "The :attribute format is invalid.",
    "exists"           => "The selected :attribute is invalid.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => "The :attribute must be an image.",
    "in"               => "The selected :attribute is invalid.",
    "integer"          => "The :attribute must be an integer.",
    "ip"               => "The :attribute must be a valid IP address.",
    "max"              => array(
        "numeric" => "The :attribute may not be greater than :max.",
        "file"    => "The :attribute may not be greater than :max kilobytes.",
        "string"  => "The :attribute may not be greater than :max characters.",
    ),
    "mimes"            => "The :attribute must be a file of type: :values.",
    "min"              => array(
        "numeric" => "The :attribute must be at least :min.",
        "file"    => "The :attribute must be at least :min kilobytes.",
        "string"  => "The :attribute must be at least :min characters.",
    ),
    "not_in"           => "The selected :attribute is invalid.",
    "numeric"          => "The :attribute must be a number.",
    "regex"            => "The :attribute format is invalid.",
    "required"         => "The :attribute field is required.",
    "required_if"      => "The :attribute field is required when :other is :value.",
    "required_with"    => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "same"             => "The :attribute and :other must match.",
    "size"             => array(
        "numeric" => "The :attribute must be :size.",
        "file"    => "The :attribute must be :size kilobytes.",
        "string"  => "The :attribute must be :size characters.",
    ),
    "unique"           => "The :attribute has already been taken.",
    "url"              => "The :attribute format is invalid.",
    "statuslabel_type" => "You must select a valid status label type",
    "unique_undeleted" => "The :attribute must be unique.",
=======
    "accepted"         => ":attribute 必須接受",
    "active_url"       => "屬性不是有效的URL",
    "after"            => ":attribute 必須在 :date 之後",
    "alpha"            => ":attribute 只能包含字母",
    "alpha_dash"       => ":attribute 只能包含字母，數字和'-'",
    "alpha_num"        => ":attribute 只允許字母和數字",
    "before"           => ":attribute 必須在 :date 之前",
    "between"          => array(
        "numeric" => ":attribute 必須在 :min - :max 之間",
        "file"    => ":attribute 必須在 :min - :max KB 之間",
        "string"  => ":attribute 必須在 :min - :max 字元之間",
    ),
    "confirmed"        => ":attribute 屬性不相符",
    "date"             => ":attribute 不是有效日期",
    "date_format"      => ":attribute 不符合 :format 的格式",
    "different"        => ":attribute 和 :other 不能相同",
    "digits"           => ":attribute 必須是 :digits 數字",
    "digits_between"   => ":attribute 必須在 :min 和 :max 之间",
    "email"            => ":attribute 格式不正確",
    "exists"           => "選擇的 :attribute 無效",
    "email_array"      => "一個或多個郵件地址不正確",
    "image"            => ":attribute 必須是圖片格式",
    "in"               => "選擇的 :attribute 無效",
    "integer"          => ":attribute 必須是整數",
    "ip"               => ":attribute 必須是有效 IP",
    "max"              => array(
        "numeric" => ":attribute 不可大於 :max",
        "file"    => ":attribute 不可大於 :max KB",
        "string"  => ":attribute 不可大於 :max 個字元",
    ),
    "mimes"            => ":attribute 檔案類型必須是 :values",
    "min"              => array(
        "numeric" => ":attribute 最少 :min",
        "file"    => ":attribute 最小 :min KB",
        "string"  => ":attribute 最少要有 :min 個字元",
    ),
    "not_in"           => "選擇的 :attribute 無效",
    "numeric"          => ":attribute 必須是數字",
    "regex"            => ":attribute 格式不正確",
    "required"         => ":attribute 欄位必填",
    "required_if"      => ":attribute 欄位在 :other 是 :value 時是必填的",
    "required_with"    => "當設定 :value 時，:attribute 欄位必填",
    "required_without" => "當設定非 :value 時，:attribute 欄位必填",
    "same"             => ":attribute 和 :other 必需相符",
    "size"             => array(
        "numeric" => ":attribute 必須是 :size",
        "file"    => ":attribute 必須是 :size KB",
        "string"  => ":attribute 必須是 :size 個字元",
    ),
    "unique"           => ":attribute 已被採用",
    "url"              => ":attribute 格式不正確",
    "statuslabel_type" => "您必須選擇一個有效的狀態標籤",
    "unique_undeleted" => ":attribute 必須唯一",
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72


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
<<<<<<< HEAD
    'alpha_space' => "The :attribute field contains a character that is not allowed.",
=======
    'alpha_space' => ":attribute 含有無效字元",
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
