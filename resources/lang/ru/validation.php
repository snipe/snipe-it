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

    'accepted'             => ':attribute должен быть принят.',
    'active_url'           => ':attribute некорректный URL.',
    'after'                => 'The :attribute должен быть после :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute может содержать только символы.',
    'alpha_dash'           => ':attribute может содержать только буквы, цифры и тире.',
    'alpha_num'            => ':attribute может содержать только буквы и цифры.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute должен быть датой до :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute должен быть между :min - :max.',
        'file'    => ':attribute должен быть между :min - :max килобайт.',
        'string'  => ':attribute должен быть между :min - :max символов.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute должен быть true или false.',
    'confirmed'            => 'Подтверждение :attribute не совпадает.',
    'date'                 => ':attribute неправильная дата.',
    'date_format'          => ':attribute не совпадает с форматом :format.',
    'different'            => ':attribute и :other должны быть разными.',
    'digits'               => ':attribute должен содержать :digits цифр.',
    'digits_between'       => ':attribute должно быть между :min и :max цифр.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Неправильный формат :attribute.',
    'exists'               => 'Выбранный :attribute неправильный.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute должен быть изображением.',
    'in'                   => 'Выбранный :attribute неправильный.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute должно быть числом.',
    'ip'                   => ':attribute должно быть IP адресом.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute не должно быть больше :max.',
        'file'    => ':attribute не должен превышать :max килобайт.',
        'string'  => ':attribute не должно превышать :max символов.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute тип файла должен быть: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute должно быть не менее :min.',
        'file'    => ':attribute должно быть не менее :min килобайт.',
        'string'  => ':attribute должно быть не менее :min символов.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Выбранный :attribute неправильный.',
    'numeric'              => ':attribute должно быть числом.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Неправильный формат :attribute.',
    'required'             => ':attribute обязательное поле.',
    'required_if'          => ':attribute обязательное поле, когда :other :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute обязательное поле, когда присутствует :values.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute обязательное поле, когда отсутствует :values.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => ':attribute должен быть :size.',
        'file'    => ':attribute должен быть :size килобайт.',
        'string'  => ':attribute должен быть :size символов.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute уже занят.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Неправильный формат :attribute.',

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
