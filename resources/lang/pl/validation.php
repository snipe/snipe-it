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

    'accepted'             => ':attribute musi zostać zaakceptowany.',
    'active_url'           => ':attribute nie jest poprawnym adresem URL.',
    'after'                => ':attribute musi być późniejszą datą w stosunku do :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute może zawierać tylko litery.',
    'alpha_dash'           => ':attribute może zawierać tylko litery, cyfry i myślniki.',
    'alpha_num'            => ':attribute może zawierać tylko litery i cyfry.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute musi być późniejszą datą w stosunku do :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute musi być pomiędzy :min - :max.',
        'file'    => ':attribute musi być pomiędzy :min - :max kilobajtów.',
        'string'  => ':attribute musi być pomiędzy :min - :max znaków.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Potwierdzenie :attribute nie pasuje.',
    'date'                 => ':attribute nie jest prawidłową datą.',
    'date_format'          => 'Format :attribute nie pasuje do :format.',
    'different'            => ':attribute musi różnić się od :other.',
    'digits'               => ':attribute musi posiadać cyfry :digits.',
    'digits_between'       => ':attribute musi być pomiędzy cyframi :min i :max.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Format pola :attribute jest niewłaściwy.',
    'exists'               => 'Wybrane :attribute jest niewłaściwe.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute musi być obrazkiem.',
    'in'                   => 'Wybrane :attribute jest niewłaściwe.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute must musi być liczbą całkowitą.',
    'ip'                   => ':attribute musi być poprawnym adresem IP.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute nie może być większy niż :max.',
        'file'    => ':attribute nie może być więszky niż :max kilobajtów.',
        'string'  => ':attribute nie może posiadać więcej znaków niż :max.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute musi być plikiem z rozszerzeniami :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute musi być przynajmniej :min.',
        'file'    => ':attribute musi być przynajmniej wielkości :min kilobajtów.',
        'string'  => ':attribute musi być posiadać minimum :min znaki.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Wybrany :attribute jest nieprawidłowy.',
    'numeric'              => ':attribute musi być liczbą.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Format :attribute jest niewłaściwy.',
    'required'             => ':attribute nie może być puste.',
    'required_if'          => 'Pole :attribute jest wymagane gdy :other jest :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Pole :attribute jest wymagane gdy :values jest podana.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Pole :attribute jest wymagane gdy :values nie jest podana.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute i :other muszą pasować.',
    'size'                 => [
        'numeric' => ':attribute musi być wielkości :size.',
        'file'    => ':attribute musi być :size kilobajtów.',
        'string'  => ':attribute musi być :size znakowy.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute został już wzięty.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Format pola :attribute jest niewłaściwy.',

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
