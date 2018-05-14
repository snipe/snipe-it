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

    'accepted'             => ':attribute мора да биде прифатен.',
    'active_url'           => ':attribute не е валидна врска (URL).',
    'after'                => ':attribute мора да биде датум после :date.',
    'after_or_equal'       => ':attribute мора да биде датум после или на :date.',
    'alpha'                => ':attribute може да содржи само букви.',
    'alpha_dash'           => ':attribute може да содржи само букви, бројки и цртички.',
    'alpha_num'            => ':attribute може да содржи само букви и броеви.',
    'array'                => ':attribute мора да биде низа.',
    'before'               => ':attribute мора да биде датум пред :date.',
    'before_or_equal'      => ':attribute мора да биде датум пред или на :date.',
    'between'              => [
        'numeric' => ':attribute мора да биде помеѓу :min - :max.',
        'file'    => ':attribute мора да биде помеѓу :min - :max килобајти.',
        'string'  => ':attribute мора да биде помеѓу :min - :max знаци.',
        'array'   => ':attribute мора да содржи помеѓу :min - :max ставки.',
    ],
    'boolean'              => ':attribute мора да биде точно/неточно.',
    'confirmed'            => 'Потврдата за :attribute не се совпаѓа.',
    'date'                 => ':attribute не е валиден датум.',
    'date_format'          => ':attribute не се совпаѓа со форматот :format.',
    'different'            => ':attribute и :other мора да се различни.',
    'digits'               => ':attribute мора да биде :digits цифри.',
    'digits_between'       => ':attribute мора да содржи помеѓу :min и :max цифри.',
    'dimensions'           => ':attribute има неважечки димензии на сликата.',
    'distinct'             => 'Полето :attribute има дупликат вредност.',
    'email'                => 'Форматот на :attribute не е валиден.',
    'exists'               => 'Избраниот :attribute не е валиден.',
    'file'                 => ':attribute мора да биде датотека.',
    'filled'               => 'Полето :attribute мора да има дупликат.',
    'image'                => ':attribute мора да биде слика.',
    'in'                   => 'Избраниот :attribute не е валиден.',
    'in_array'             => 'Полето :attribute не постои во :other.',
    'integer'              => ':attribute мора да биде цел број.',
    'ip'                   => ':attribute мора да биде валидна IP адреса.',
    'ipv4'                 => ':attribute мора да биде валидна IPv4 адреса.',
    'ipv6'                 => ':attribute мора да биде валидна IPv6 адреса.',
    'json'                 => ':attribute мора да биде валиден JSON стринг.',
    'max'                  => [
        'numeric' => ':attribute не може да биде поголем од :max.',
        'file'    => ':attribute не може да биде поголем од :max килобајти.',
        'string'  => ':attribute не може да биде поголем од :max значи.',
        'array'   => ':attribute не може да содржи повеќе од :max ставки.',
    ],
    'mimes'                => ':attribute мора да биде датотека од тип: :values.',
    'mimetypes'            => ':attribute мора да биде датотека од тип: :values.',
    'min'                  => [
        'numeric' => ':attribute мора да биде поголем од :min.',
        'file'    => ':attribute мора да биде поголем од :min килобајти.',
        'string'  => ':attribute мора да биде поголем од :min знаци.',
        'array'   => ':attribute мора да содржи најмалку :min ставки.',
    ],
    'not_in'               => 'Избраниот :attribute не е валиден.',
    'numeric'              => ':attribute мора да биде број.',
    'present'              => 'Полето :attribute е задолжително.',
    'valid_regex'          => 'Тоа не е валиден regex. ',
    'regex'                => 'Форматот на :attribute не е валиден.',
    'required'             => 'Полето за :attribute е задолжително.',
    'required_if'          => 'Полето :attribute е задолжително, кога :other е :values.',
    'required_unless'      => 'Полето :attribute е задолжително, освен ако :other е :values.',
    'required_with'        => 'Полето :attribute е задолжително кога постојат :values.',
    'required_with_all'    => 'Полето :attribute е задолжително кога постојат :values.',
    'required_without'     => 'Полето :attribute е задолжително кога не постојат :values.',
    'required_without_all' => 'Полето :attribute е задолжително кога не постои ниту една :values.',
    'same'                 => ':attribute и :other мора да одговараат.',
    'size'                 => [
        'numeric' => ':attribute мора да биде :size.',
        'file'    => ':attribute мора да биде :size килобајти.',
        'string'  => ':attribute мора да биде :size знаци.',
        'array'   => ':attribute мора да содржи :size ставки.',
    ],
    'string'               => ':attribute мора да биде стринг.',
    'timezone'             => ':attribute мора да биде валидна зона.',
    'unique'               => ':attribute е веќе зафатен.',
    'uploaded'             => ':attribute не е прикачен.',
    'url'                  => 'Форматот на :attribute не е валиден.',
    "unique_undeleted"     => ":attribute мора да биде уникатен.",

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
        'alpha_space' => "Полето :attribute содржи знак што не е дозволен.",
        "email_array"      => "Една или повеќе е-пошти не се валидни.",
        "hashed_pass"      => "Вашата тековна лозинка е неточна",
        'dumbpwd'          => 'Таа лозинка е премногу честа.',
        "statuslabel_type" => "Мора да изберете валидна етикета за статус",
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
