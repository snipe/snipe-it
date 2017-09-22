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

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL correcta.',
    'after'                => ':attribute debe ser posterior a :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute solo acepta letras.',
    'alpha_dash'           => ':attribute solo acepta letras, números y guiones.',
    'alpha_num'            => ':attribute solo acepta letras y números.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute debe ser anterior a :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min - :max.',
        'file'    => ':attribute debe estar entre :min - :max kilobytes.',
        'string'  => ':attribute debe estar entre :min - :max caracteres.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => ':attribute la confirmación no coincide.',
    'date'                 => ':attribute no es una fecha correcta.',
    'date_format'          => ':attribute no cumple el formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe tener :digits dígitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute formato incorrecto.',
    'exists'               => 'El :attribute seleccionado no es correcto.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado no es correcto.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute debe ser un número entero.',
    'ip'                   => ':attribute debe ser una dirección IP correcta.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor que :max.',
        'file'    => ':attribute no debe ser mayor que :max kilobytes.',
        'string'  => ':attribute no debe tener como máximo :max caracteres.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute debe ser un archivo del tipo: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute debe ser como mínimo :min.',
        'file'    => ':attribute debe ser como mínimo de :min kilobytes.',
        'string'  => ':attribute debe contener como mínimo :min caracteres.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'El :attribute seleccionado no es correcto.',
    'numeric'              => ':attribute debe ser un número.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute formato incorrecto.',
    'required'             => ':attribute es obligatorio.',
    'required_if'          => ':attribute es obligatrio cuando :other es :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute es obligatrio cuando :values es present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute es obligatrio cuando :values es not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => ':attribute debe tener :size.',
        'file'    => ':attribute debe tener :size kilobytes.',
        'string'  => ':attribute debe tener :size caracteres.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute ya ha sido introducido.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute formato incorrecto.',

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
