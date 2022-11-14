<?php

return [

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

    'accepted'             => 'El: atributo debe ser aceptado.',
    'active_url'           => 'El :atributo no es una URL correcta.',
    'after'                => 'El :attribute debe ser posterior a :date.',
    'after_or_equal'       => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El :attribute sólo debe contener letras.',
    'alpha_dash'           => 'El :attribute debe sólo aceptar letras, números y guiones.',
    'alpha_num'            => 'El :attribute debe sólo acepta letras y números.',
    'array'                => 'El :attribute debe ser una matriz.',
    'before'               => 'El :attribute sólo debe ser anterior a :date.',
    'before_or_equal'      => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe estar entre :min - :max.',
        'file'    => 'El :attribute debe estar entre :min - :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min - :max caracteres.',
        'array'   => 'El atributo: debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'El :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La :attribute confirmación no coincide.',
    'date'                 => 'El :attribute no es una fecha correcta.',
    'date_format'          => 'El :attribute no cumple el formato :format.',
    'different'            => 'Los :attribute y :other deben ser diferentes.',
    'digits'               => 'El :attribute debe tener :digits digitos.',
    'digits_between'       => 'El :attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'El :attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El formato :attribute es inválido.',
    'exists'               => 'El :attribute seleccionado es inválido.',
    'file'                 => 'Estte :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado es inválido.',
    'in_array'             => 'El :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un número entero.',
    'ip'                   => 'El :attribute debe ser una dirección IP correcta.',
    'ipv4'                 => 'El :atrribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El :atrribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El :atrribute debe ser una dirección IPv4 válida.',
    'max'                  => [
        'numeric' => 'El :attribute no debe ser mayor que :max kilobytes.',
        'file'    => 'El :attribute no debe tener como máximo :max caracteres.',
        'string'  => 'El :attribute no debe tener más de :max caracteres.',
        'array'   => 'El :attribute no debe tener más de :max caracteres.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo del tipo: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo del tipo: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser como mínimo :min.',
        'file'    => 'El :attribute debe ser como mínimo de :min kilobytes.',
        'string'  => 'El :attribute debe ser como mínimo de :min kilobytes.',
        'array'   => 'El :attribute debe ser como mínimo de :min kilobytes.',
    ],
    'starts_with'          => 'El :attribute debe comenzar con uno de los siguientes: :values.',
    'not_in'               => 'El :attribute seleccionado es inválido.',
    'numeric'              => 'El :attribute debe ser un número entero.',
    'present'              => 'El campo :attribute debe tener un valor.',
    'valid_regex'          => 'Este no es un regex válido. ',
    'regex'                => 'El formato :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_with'        => 'El :attribute es obligatrio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatrio cuando :values está presente.',
    'required_without'     => 'El :attribute es obligatrio cuando :values está presente.',
    'required_without_all' => 'El campo :attribute es obligatrio cuando :values es present.',
    'same'                 => 'Los :attribute y :other deben ser diferentes.',
    'size'                 => [
        'numeric' => 'Estte :attribute debe ser :size.',
        'file'    => 'El :attribute debe tener :size kilobytes.',
        'string'  => 'El :attribute debe tener :size kilobytes.',
        'array'   => 'El :attribute debe contener :size elementos.',
    ],
    'string'               => 'Este :attribute debe ser una cadena.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => 'El :attribute ya está en uso.',
    'uploaded'             => 'El :attribute fallo al cargar.',
    'url'                  => 'El formato :attribute es inválido.',
    'unique_undeleted'     => 'El :atrribute debe ser único.',
    'non_circular'         => ':attribute no debe crear una referencia circular.',
    'disallow_same_pwd_as_user_fields' => 'La contraseña no puede ser la misma que el usuario.',
    'letters'              => 'La contraseña debe contener al menos una letra.',
    'numbers'              => 'La contraseña debe contener al menos un número.',
    'case_diff'            => 'La contraseña debe usar mayúsculas y minúsculas.',
    'symbols'              => 'La contraseña debe contener símbolos.',
    'gte'                  => [
        'numeric'          => 'El valor no puede ser negativo'
    ],


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
        'alpha_space' => 'El campo :attribute contiene un caracter que no está permitido.',
        'email_array'      => 'Una o más direcciones de correo electrónico no son válidas.',
        'hashed_pass'      => 'Tu contraseña actual es incorrecta',
        'dumbpwd'          => 'Esa contraseña es muy común.',
        'statuslabel_type' => 'Debe seleccionar un tipo de etiqueta de estado válido',
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

];
