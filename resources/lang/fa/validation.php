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

    "accepted"         => "ویژگی باید تایید شود.",
    "active_url"       => "ویژگی یک URL معتبر نیست.",
    "after"            => "ویژگی باید در تاریخی بعد از تاریخ باشد.",
    "alpha"            => "ویژگی ممکن است فقط شامل حروف باشد.",
    "alpha_dash"       => "ویژگی ممکن است فقط شامل حروف، اعداد و خط های فاصله باشد.",
    "alpha_num"        => "ویژگی ممکن است فقط شامل حروف و اعداد باشد.",
    "before"           => "ویژگی باید در تاریخی قبل از تاریخ باشد.",
    "between"          => array(
        "numeric" => "ویژگی باید بین حداقل حداکثر باشد.",
        "file"    => "ویژگی باید بین حداقل حداکثر کیلوبایت باشد.",
        "string"  => "ویژگی باید بین حداقل حداکثر کاراکتر باشد.",
    ),
    "confirmed"        => "تایید ویژگی منطبق نیست.",
    "date"             => "تاریخ ویژگی معتبر نیست.",
    "date_format"      => "ویژگی منطبق بر شکل شکل نیست.",
    "different"        => "ویژگی و دیگر باید متفاوت باشد.",
    "digits"           => "ویژگی باید رقم رقم باشد.",
    "digits_between"   => "ویژگی باید بین حداقل و حداکثر رقم باشد.",
    "email"            => "شکل ویژگی نامعتبر است.",
    "exists"           => "ویژگی انتخاب شده نامعتبر است.",
    "email_array"      => "یک یا بیش از یک آدرس ایمیل نامعتبر است.",
    "image"            => "ویژگی باید یک عکس باشد.",
    "in"               => "ویژگی انتخاب شده نامعتبر است.",
    "integer"          => "ویژگی باید یک عدد باشد.",
    "ip"               => "ویژگی باید یک آدرس IP معتبر باشد.",
    "max"              => array(
        "numeric" => "ویژگی نباید بزرگتر از حداکثر باشد.",
        "file"    => "ویژگی نباید بزرگتر از حداکثر کیلوبایت باشد.",
        "string"  => "ویژگی نباید بزرگتر از حداکثر کاراکتر باشد.",
    ),
    "mimes"            => "ویژگی باید فایلی از نوع ارزش ها باشد.",
    "min"              => array(
        "numeric" => "ویژگی باید حداقل: حداقل باشد.",
        "file"    => "ویژگی باید حداقل: حداقل کیلوبایت باشد.",
        "string"  => "ویژگی باید حداقل: حداقل کاراکتر باشد.",
    ),
    "not_in"           => "ویژگی انتخاب شده نامعتبر است.",
    "numeric"          => "ویژگی باید عدد باشد.",
    "regex"            => "شکل ویژگی نامعتبر است.",
    "required"         => "فیلد ویژگی ضروری است.",
    "required_if"      => "فیلد ویژگی ضروری است، وقتی که دیگری ارزش است.",
    "required_with"    => "فیلد ویژگی ضروری است، وقتی که ارزش موجود باشد.",
    "required_without" => "فیلد ویژگی ضروری است، وقتی که ارزش ها حاضر نباشند.",
    "same"             => "ویژگی و دیگری باید بر هم منطبق باشند.",
    "size"             => array(
        "numeric" => "ویژگی باید به اندازه ی : سایز باشد.",
        "file"    => "ویژگی باید به اندازه ی: سایز کیلوبایت باشد.",
        "string"  => "ویژگی باید به اندازه ی : سایز کاراکتر باشد.",
    ),
    "unique"           => "ویژگی در حال حاضر گرفته شده است.",
    "url"              => "شکل ویژگی نامعتبر است.",
    "statuslabel_type" => "You must select a valid status label type",
    "unique_undeleted" => "The :attribute must be unique.",


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
    'alpha_space' => "فیلد ویژگی شامل یک کاراکتر غیرمجاز است.",

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
