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

    'accepted'             => ':attribute трябва да бъде потвърден.',
    'active_url'           => ':attribute не е валиден URL адрес.',
    'after'                => ':attribute трябва да бъде дата след :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute може да съдържа единствено букви.',
    'alpha_dash'           => ':attribute може да съдържа единствено букви, числа и тире.',
    'alpha_num'            => ':attribute може да съдържа единствено букви и числа.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute трябва да бъде дата преди :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute трябва да бъде между :min и :max.',
        'file'    => ':attribute трябва да бъде с големина между :min и :max KB.',
        'string'  => ':attribute трябва да бъде с дължина между :min и :max символа.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute трябва да е верен или грешен.',
    'confirmed'            => ':attribute потвърждение не съвпада.',
    'date'                 => ':attribute не е валидна дата.',
    'date_format'          => ':attribute не съвпада с формата :format.',
    'different'            => ':attribute и :other трябва да се различават.',
    'digits'               => ':attribute трябва да бъде с дължина :digits цифри.',
    'digits_between'       => ':attribute трябва да бъде с дължина между :min и :max цифри.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute е с невалиден формат.',
    'exists'               => 'Избраният :attribute е невалиден.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute трябва да бъде изображение.',
    'in'                   => 'Избраният :attribute е невалиден.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute трябва да бъде целочислен.',
    'ip'                   => ':attribute трябва да бъде валиден IP адрес.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute не може да бъде по-дълъг от :max.',
        'file'    => ':attribute не може да бъде по-голям от :max KB.',
        'string'  => ':attribute не може да бъде по-дълъг от :max символа.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute трябва да бъде файл с един от следните типове: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute трябва да бъде минимум :min.',
        'file'    => ':attribute трябва да бъде с големина минимум :min KB.',
        'string'  => ':attribute трябва да бъде минимум :min символа.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Избраният :attribute е невалиден.',
    'numeric'              => ':attribute трябва да бъде число.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Форматът на :attribute е невалиден.',
    'required'             => 'Полето :attribute е задължително.',
    'required_if'          => 'Полето :attribute е задължително, когато :other е :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute е задължителен, когато са избрани :values.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute е задължителен, когато не са избрани :values.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute и :other трябва да съвпадат.',
    'size'                 => [
        'numeric' => ':attribute трябва да бъде с дължина :size.',
        'file'    => ':attribute трябва да бъде с големина :size KB.',
        'string'  => ':attribute трябва да бъде с дължина :size символа.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute вече е вписан.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Форматът на :attribute е невалиден.',

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
