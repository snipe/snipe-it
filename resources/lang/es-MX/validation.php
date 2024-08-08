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

<<<<<<< HEAD
    'accepted' => 'El campo :attribute debe ser aceptado.',
    'accepted_if' => 'El campo :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => 'El campo :attribute debe ser una dirección URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo :attribute debe contener únicamente letras.',
    'alpha_dash' => 'El campo :attribute debe contener únicamente letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El campo :attribute debe contener únicamente letras y números.',
    'array' => 'El campo :attribute debe ser un arreglo.',
    'ascii' => 'El campo :attribute debe contener únicamente caracteres y símbolos alfanuméricos de un byte.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'array' => 'El campo :attribute debe tener elementos entre :min y :max.',
        'file' => 'El campo :attribute debe tener entre :min y :max kilobytes.',
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'can' => 'El campo :attribute contiene un valor no autorizado.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'contains' => 'Falta un valor obligatorio en el campo :attribute.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El campo :attribute debe contener una fecha válida.',
    'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El campo :attribute debe coincidir con el formato :format.',
    'decimal' => 'El campo :attribute debe tener :decimal lugares decimales.',
    'declined' => 'El campo :attribute debe ser rechazado.',
    'declined_if' => 'El campo :attribute debe ser rechazado cuando :other es :value.',
    'different' => 'Los campos :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'dimensions' => 'El campo :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'El campo: atributo tiene un valor duplicado.',
    'doesnt_end_with' => 'El campo :attribute no debe finalizar con uno de los siguientes :values.',
    'doesnt_start_with' => 'El campo :attribute no debe iniciar con uno de los siguientes :values.',
    'email' => 'El campo :attribute debe ser una dirección de correo válida.',
    'ends_with' => 'El campo :attribute debe finalizar con uno de los siguientes :values.',
    'enum' => 'El :attribute seleccionado no es correcto.',
    'exists' => 'El :attribute seleccionado no es correcto.',
    'extensions' => 'El campo :attribute debe tener una de las siguientes extensiones :values.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo: atributo debe tener un valor.',
    'gt' => [
        'array' => 'El campo :attribute debe tener más de :value elementos.',
        'file' => 'El campo :attribute debe ser mayor que :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor que :value.',
        'string' => 'El campo :attribute debe ser mayor que :value caracteres.',
    ],
    'gte' => [
        'array' => 'El campo :attribute debe tener :value elementos o más.',
        'file' => 'El campo :attribute debe ser mayor que o igual a :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor que o igual a :value.',
        'string' => 'El campo :attribute debe ser mayor que o igual a :value caracteres.',
    ],
    'hex_color' => 'El campo :attribute debe ser un color hexadecimal válido.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'import_field_empty'    => 'El valor para :fieldname no puede ser nulo.',
    'in' => 'El :attribute seleccionado no es correcto.',
    'in_array' => 'El campo :attribute debe existir en :other.',
    'integer' => 'El campo :attribute debe ser un valor entero.',
    'ip' => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'list' => 'The campo :attribute debe ser una lista.',
    'lowercase' => 'El campo :attribute debe estar en minúsculas.',
    'lt' => [
        'array' => 'El campo :attribute debe tener menos que :value elementos.',
        'file' => 'El campo :attribute debe ser menor que :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser menor que :value.',
        'string' => 'El campo :attribute debe ser menor que :value caracteres.',
    ],
    'lte' => [
        'array' => 'El campo :attribute no debe tener más de :value elementos.',
        'file' => 'El campo :attribute debe ser menor que o igual a :value kylobytes.',
        'numeric' => 'El campo :attribute debe ser menor que o igual a :value.',
        'string' => 'El campo :attribute debe ser menor que o igual a :value caracteres.',
    ],
    'mac_address' => 'El campo :attribute debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'El campo :attribute no debe tener más de :max elementos.',
        'file' => 'El campo :attribute no debe ser mayor que :max kilobytes.',
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string' => 'El campo :attribute no debe ser mayor que :max caracteres.',
    ],
    'max_digits' => 'El campo :attribute no debe tener más de :max dígitos.',
    'mimes' => 'El campo :attribute debe un archivo de tipo: :values.',
    'mimetypes' => 'El campo :attribute debe un archivo de tipo: :values.',
    'min' => [
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
        'file' => 'El campo :attribute debe ser de al menos :min kilobytes.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe contener como mínimo :min caracteres.',
    ],
    'min_digits' => 'El campo :attribute debe contener como mínimo :min dígitos.',
    'missing' => 'El campo :attribute debe estar vacío.',
    'missing_if' => 'El campo :attribute debe estar vacío cuando :other sea :value.',
    'missing_unless' => 'El campo :attribute debe estar vacío a menos que :other sea :value.',
    'missing_with' => 'El campo :attribute debe estar vacío cuando :values esté presente.',
    'missing_with_all' => 'El campo :attribute debe estar vacío cuando :values estén presentes.',
    'multiple_of' => 'El campo :attribute debe ser un múltiplo de :value.',
    'not_in' => 'El :attribute seleccionado no es correcto.',
    'not_regex' => 'El campo :attribute no es válido.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'password' => [
        'letters' => 'El cammpo :attribute debe contener al menos una letra.',
        'mixed' => 'El campo :attribute debe contener al menos una letra minúscula y una mayúscula.',
        'numbers' => 'El campo :attribute debe contener al menos un número.',
        'symbols' => 'El campo :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'El valor de :attribute ha aparecido en una fuga de datos. Por favor, seleccione un valor diferente para :attribute.',
    ],
    'present' => 'El campo: atributo debe estar presente.',
    'present_if' => 'El campo :attribute debe estar presente cuando :other sea :value.',
    'present_unless' => 'El campo :attribute debe estar presente a menos que :other sea :value.',
    'present_with' => 'El campo :attribute debe estar presente cuando :values esté presente.',
    'present_with_all' => 'El campo :attribute debe estar presente cuando :values estén presentes.',
    'prohibited' => 'El campo :attribute está prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other sea :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute prohíbe la presencia de :other.',
    'regex' => 'El formato del campo :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_array_keys' => 'El campo :attribute debe contener valores para: :values.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_if_accepted' => 'El campo :attribute es obligatorio cuando se acepta :other.',
    'required_if_declined' => 'El campo :attribute es requerido cuando :other es rechazado.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => ':attribute es obligatrio cuando :values es present.',
    'required_with_all' => 'El campo :attribute es requerido cuando :values están presentes.',
    'required_without' => ':attribute es obligatrio cuando :values es not present.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando no está presente ninguno de los :values.',
    'same' => 'El campo :attribute debe coincidir con :other.',
    'size' => [
        'array' => 'El campo :attribute debe contenter :size elementos.',
        'file' => 'El campo :attribute debe ser de :size kilobytes.',
        'numeric' => 'El campo :attribute debe ser :size.',
        'string' => 'El campo :attribute debe ser de :size caracteres.',
    ],
    'starts_with' => 'El campo :attribute debe iniciar con uno de los siguientes: :values.',
    'string'               => 'El atributo: debe ser una cadena.',
    'two_column_unique_undeleted' => ':attribute debe ser único a través de :table1 y :table2. ',
    'unique_undeleted'     => 'El :atrribute debe ser único.',
    'non_circular'         => ':attribute no debe crear una referencia circular.',
    'not_array'            => ':attribute no puede ser una matriz.',
    'disallow_same_pwd_as_user_fields' => 'La contraseña no puede ser la misma que el nombre de usuario.',
    'letters'              => 'La contraseña debe contener al menos una letra.',
    'numbers'              => 'La contraseña debe contener al menos un número.',
    'case_diff'            => 'La contraseña debe usar mayúsculas y minúsculas.',
    'symbols'              => 'La contraseña debe contener símbolos.',
    'timezone' => 'El campo :attribute debe ser una zona horaria válida.',
    'unique' => ':attribute ya ha sido introducido.',
    'uploaded' => 'El atributo: no se pudo cargar.',
    'uppercase' => 'El campo :attribute debe estar en mayúsculas.',
    'url' => 'El campo :attribute debe ser una URL válida.',
    'ulid' => 'El campo :attribute debe ser un ULID válido.',
    'uuid' => 'El campo :attribute debe ser un UUID válido.',
=======
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
>>>>>>> 64747d0fb (updates based on review)

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
<<<<<<< HEAD
        'hashed_pass'      => 'Su contraseña actual es incorrecta',
        'dumbpwd'          => 'Esa contraseña es muy común.',
        'statuslabel_type' => 'Debe seleccionar un tipo de etiqueta de estado válido.',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format.
        'purchase_date.date_format'     => ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'last_audit_date.date_format'   =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD hh:mm:ss',
        'expiration_date.date_format'   =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'termination_date.date_format'  =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'expected_checkin.date_format'  =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'start_date.date_format'        =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'end_date.date_format'          =>  ':attribute debe ser una fecha válida con formato AAA-MM-DD',
        'checkboxes'           => ':attribute contiene opciones no válidas.',
        'radio_buttons'        => 'El valor de :attribute no es válido.',
        'invalid_value_in_field' => 'Valor no válido incluido en este campo',
        ],
=======
        'hashed_pass'      => 'Tu contraseña actual es incorrecta',
        'dumbpwd'          => 'Esa contraseña es muy común.',
        'statuslabel_type' => 'Debe seleccionar un tipo de etiqueta de estado válido.',
    ],

>>>>>>> 64747d0fb (updates based on review)
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

<<<<<<< HEAD
    /*
    |--------------------------------------------------------------------------
    | Generic Validation Messages - we use these in the jquery validation where we don't have
    | access to the :attribute
    |--------------------------------------------------------------------------
    */

    'generic' => [
        'invalid_value_in_field' => 'Valor no válido incluido en este campo',
        'required' => 'El campo es obligatorio',
        'email' => 'Por favor, ingrese una dirección de correo electrónico válida.',
    ],


=======
>>>>>>> 64747d0fb (updates based on review)
];
