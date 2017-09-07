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

    'accepted'             => 'ویژگی باید تایید شود.',
    'active_url'           => 'ویژگی یک URL معتبر نیست.',
    'after'                => 'ویژگی باید در تاریخی بعد از تاریخ باشد.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'ویژگی ممکن است فقط شامل حروف باشد.',
    'alpha_dash'           => 'ویژگی ممکن است فقط شامل حروف، اعداد و خط های فاصله باشد.',
    'alpha_num'            => 'ویژگی ممکن است فقط شامل حروف و اعداد باشد.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'ویژگی باید در تاریخی قبل از تاریخ باشد.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'ویژگی باید بین حداقل حداکثر باشد.',
        'file'    => 'ویژگی باید بین حداقل حداکثر کیلوبایت باشد.',
        'string'  => 'ویژگی باید بین حداقل حداکثر کاراکتر باشد.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'تایید ویژگی منطبق نیست.',
    'date'                 => 'تاریخ ویژگی معتبر نیست.',
    'date_format'          => 'ویژگی منطبق بر شکل شکل نیست.',
    'different'            => 'ویژگی و دیگر باید متفاوت باشد.',
    'digits'               => 'ویژگی باید رقم رقم باشد.',
    'digits_between'       => 'ویژگی باید بین حداقل و حداکثر رقم باشد.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'شکل ویژگی نامعتبر است.',
    'exists'               => 'ویژگی انتخاب شده نامعتبر است.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'ویژگی باید یک عکس باشد.',
    'in'                   => 'ویژگی انتخاب شده نامعتبر است.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'ویژگی باید یک عدد باشد.',
    'ip'                   => 'ویژگی باید یک آدرس IP معتبر باشد.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'ویژگی نباید بزرگتر از حداکثر باشد.',
        'file'    => 'ویژگی نباید بزرگتر از حداکثر کیلوبایت باشد.',
        'string'  => 'ویژگی نباید بزرگتر از حداکثر کاراکتر باشد.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'ویژگی باید فایلی از نوع ارزش ها باشد.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'ویژگی باید حداقل: حداقل باشد.',
        'file'    => 'ویژگی باید حداقل: حداقل کیلوبایت باشد.',
        'string'  => 'ویژگی باید حداقل: حداقل کاراکتر باشد.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'ویژگی انتخاب شده نامعتبر است.',
    'numeric'              => 'ویژگی باید عدد باشد.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'شکل ویژگی نامعتبر است.',
    'required'             => 'فیلد ویژگی ضروری است.',
    'required_if'          => 'فیلد ویژگی ضروری است، وقتی که دیگری ارزش است.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'فیلد ویژگی ضروری است، وقتی که ارزش موجود باشد.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'فیلد ویژگی ضروری است، وقتی که ارزش ها حاضر نباشند.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'ویژگی و دیگری باید بر هم منطبق باشند.',
    'size'                 => [
        'numeric' => 'ویژگی باید به اندازه ی : سایز باشد.',
        'file'    => 'ویژگی باید به اندازه ی: سایز کیلوبایت باشد.',
        'string'  => 'ویژگی باید به اندازه ی : سایز کاراکتر باشد.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'ویژگی در حال حاضر گرفته شده است.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'شکل ویژگی نامعتبر است.',

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
