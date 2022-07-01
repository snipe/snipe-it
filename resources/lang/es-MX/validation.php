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

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL correcta.',
    'after'                => ':attribute debe ser posterior a :date.',
    'after_or_equal'       => 'El atributo: debe ser una fecha posterior o igual a: fecha.',
    'alpha'                => ':attribute solo acepta letras.',
    'alpha_dash'           => ':attribute solo acepta letras, números y guiones.',
    'alpha_num'            => ':attribute solo acepta letras y números.',
    'array'                => 'El: atributo debe ser una matriz.',
    'before'               => ':attribute debe ser anterior a :date.',
    'before_or_equal'      => 'El atributo: debe ser una fecha anterior o igual a: fecha.',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min - :max.',
        'file'    => ':attribute debe estar entre :min - :max kilobytes.',
        'string'  => ':attribute debe estar entre :min - :max caracteres.',
        'array'   => 'El atributo: debe tener entre: min y: elementos máximos.',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => ':attribute la confirmación no coincide.',
    'date'                 => ':attribute no es una fecha correcta.',
    'date_format'          => ':attribute no cumple el formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe tener :digits dígitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'El atributo: tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El campo: atributo tiene un valor duplicado.',
    'email'                => ':attribute formato incorrecto.',
    'exists'               => 'El :attribute seleccionado no es correcto.',
    'file'                 => 'El: atributo debe ser un archivo.',
    'filled'               => 'El campo: atributo debe tener un valor.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado no es correcto.',
    'in_array'             => 'El campo: atributo no existe en: otro.',
    'integer'              => ':attribute debe ser un número entero.',
    'ip'                   => ':attribute debe ser una dirección IP correcta.',
    'ipv4'                 => 'El atributo: debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El atributo: debe ser una dirección IPv6 válida.',
    'json'                 => 'El atributo: debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor que :max.',
        'file'    => ':attribute no debe ser mayor que :max kilobytes.',
        'string'  => ':attribute no debe tener como máximo :max caracteres.',
        'array'   => 'El atributo: puede no tener más que: elementos máximos.',
    ],
    'mimes'                => ':attribute debe ser un archivo del tipo: :values.',
    'mimetypes'            => 'El atributo: debe ser un archivo de tipo:: valores.',
    'min'                  => [
        'numeric' => ':attribute debe ser como mínimo :min.',
        'file'    => ':attribute debe ser como mínimo de :min kilobytes.',
        'string'  => ':attribute debe contener como mínimo :min caracteres.',
        'array'   => 'El atributo: debe tener al menos: elementos min.',
    ],
    'starts_with'          => 'El :attribute debe comenzar con uno de los siguientes: :values.',
    'not_in'               => 'El :attribute seleccionado no es correcto.',
    'numeric'              => ':attribute debe ser un número.',
    'present'              => 'El campo: atributo debe estar presente.',
    'valid_regex'          => 'Este no es un regex válido. ',
    'regex'                => ':attribute formato incorrecto.',
    'required'             => ':attribute es obligatorio.',
    'required_if'          => ':attribute es obligatrio cuando :other es :value.',
    'required_unless'      => 'El campo: atributo es obligatorio a menos que: otro esté en: valores.',
    'required_with'        => ':attribute es obligatrio cuando :values es present.',
    'required_with_all'    => 'El campo: atributo se requiere cuando: los valores están presentes.',
    'required_without'     => ':attribute es obligatrio cuando :values es not present.',
    'required_without_all' => 'El campo: atributo es necesario cuando ninguno de: valores están presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => ':attribute debe tener :size.',
        'file'    => ':attribute debe tener :size kilobytes.',
        'string'  => ':attribute debe tener :size caracteres.',
        'array'   => 'El atributo: debe contener: elementos de tamaño.',
    ],
    'string'               => 'El atributo: debe ser una cadena.',
    'timezone'             => 'El atributo: debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido introducido.',
    'uploaded'             => 'El atributo: no se pudo cargar.',
    'url'                  => ':attribute formato incorrecto.',
    'unique_undeleted'     => 'El :atrribute debe ser único.',
    'non_circular'         => ':attribute no debe crear una referencia circular.',
    'disallow_same_pwd_as_user_fields' => 'Password cannot be the same as the username.',
    'letters'              => 'Password must contain at least one letter.',
    'numbers'              => 'Password must contain at least one number.',
    'case_diff'            => 'Password must use mixed case.',
    'symbols'              => 'Password must contain symbols.',
    'gte'                  => [
        'numeric'          => 'Value cannot be negative'
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
        'alpha_space' => 'El campo: atributo contiene un carácter que no está permitido.',
        'email_array'      => 'Una o más direcciones de correo electrónico no es válida.',
        'hashed_pass'      => 'Tu contraseña actual es incorrecta',
        'dumbpwd'          => 'Esa contraseña es muy común.',
        'statuslabel_type' => 'Debe seleccionar un tipo de etiqueta de estado válido.',
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
