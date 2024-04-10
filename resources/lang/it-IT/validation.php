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

    'accepted'             => ':attribute deve essere accettato.',
    'active_url'           => ':attribute non è un URL valido.',
    'after'                => ':attribute deve essere una data oltre il  :date.',
    'after_or_equal'       => ':attribute deve essere una data successiva o uguale a :date .',
    'alpha'                => ':attribute può contenere solo lettere.',
    'alpha_dash'           => ':attribute può contenere solo lettere numeri e trattini.',
    'alpha_num'            => ':attribute può contenere solo lettere e numeri.',
    'array'                => ':attribute deve essere un array.',
    'before'               => ':attribute deve essere una data precedente il :date .',
    'before_or_equal'      => ':attribute deve essere una data precedente o uguale al :date .',
    'between'              => [
        'numeric' => ':attribute deve essere tra :min - :max .',
        'file'    => 'il :attribute deve essere tra  :min - :max kilobytes.',
        'string'  => 'il :attribute deve essere tra :min - :max caratteri.',
        'array'   => ':attribute deve avere tra: min e: max elementi.',
    ],
    'boolean'              => ':attribute deve essere o vero o falso.',
    'confirmed'            => 'La conferma di :attribute non corrisponde.',
    'date'                 => ':attribute non è una data valida.',
    'date_format'          => 'il :attribute non corrisponde al :format.',
    'different'            => ':attribute e :other devono essere differenti.',
    'digits'               => ':attribute deve essere :digits cifre.',
    'digits_between'       => ':attribute deve essere tra :min e :max cifre.',
    'dimensions'           => ':attribute ha dimensioni di immagine non valide.',
    'distinct'             => 'Il campo :attribute ha un valore duplicato.',
    'email'                => 'Il formato di :attribute non è valido.',
    'exists'               => ':attribute selezionato non è valido.',
    'file'                 => ':attribute deve essere un file.',
    'filled'               => 'Il campo :attribute deve avere un valore.',
    'image'                => ':attribute deve essere un\'immagine.',
    'import_field_empty'    => ':fieldname non può essere vuoto.',
    'in'                   => ':attribute selezionato non è valido.',
    'in_array'             => 'Il campo :attribute non esiste in :other.',
    'integer'              => ':attribute deve essere un numero intero.',
    'ip'                   => ':attribute deve essere un indirizzo IP valido.',
    'ipv4'                 => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'                 => ':attribute deve essere un indirizzo IPv6 valido.',
    'is_unique_department' => ':attribute deve essere unico per questa sede aziendale',
    'json'                 => ':attribute deve essere una stringa JSON valida.',
    'max'                  => [
        'numeric' => ':attribute non può essere maggiore di :max.',
        'file'    => ':attribute non può essere maggiore di :max kilobytes.',
        'string'  => ':attribute non può essere maggiore di :max caratteri.',
        'array'   => ':attribute non può avere più di :max elementi.',
    ],
    'mimes'                => ':attribute deve essere un file di formato: :values.',
    'mimetypes'            => ':attribute deve essere un file di formato: :values.',
    'min'                  => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno :min kilobytes.',
        'string'  => ':attribute deve essere di almeno :min caratteri.',
        'array'   => ':attribute deve avere almeno :min elementi.',
    ],
    'starts_with'          => ':attribute deve iniziare con uno dei seguenti: :values.',
    'ends_with'            => ':attribute deve finire con uno dei seguenti: :values.',

    'not_in'               => ':attribute selezionato non è valido.',
    'numeric'              => ':attribute dev\'essere un numero.',
    'present'              => 'Il campo :attribute deve essere presente.',
    'valid_regex'          => 'Questa non è una espressione regolare valida. ',
    'regex'                => 'Il formato di :attribute non è valido.',
    'required'             => 'Il campo :attribute è obbligatorio.',
    'required_if'          => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è obbligatorio a meno che :other sia in :values.',
    'required_with'        => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_without'     => 'Il campo :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno dei valori :values è presente.',
    'same'                 => ':attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere :size kilobytes.',
        'string'  => ':attribute deve essere :size caratteri.',
        'array'   => ':attribute deve contenere :size elementi.',
    ],
    'string'               => ':attribute deve essere una stringa.',
    'timezone'             => ':attribute deve essere una zona valida.',
    'two_column_unique_undeleted' => ':attribute deve essere univoco tra :table1 e :table2 . ',
    'unique'               => ':attribute è già stato preso.',
    'uploaded'             => 'Non è stato possibile caricare :attribute.',
    'url'                  => 'Il formato di :attribute non è valido.',
    'unique_undeleted'     => ':attribute deve essere unico.',
    'non_circular'         => ':attribute non deve creare un riferimento circolare.',
    'not_array'            => ':attribute non può essere un array.',
    'disallow_same_pwd_as_user_fields' => 'La password non può essere uguale al nome utente.',
    'letters'              => 'La password deve contenere almeno una lettera.',
    'numbers'              => 'La password deve contenere almeno un numero.',
    'case_diff'            => 'La password deve utilizzare maiuscole e minuscole.',
    'symbols'              => 'La password deve contenere simboli.',
    'gte'                  => [
        'numeric'          => 'Il valore non può essere negativo'
    ],
    'checkboxes'           => ':attribute contiene opzioni non valide.',
    'radio_buttons'        => ':attribute non è valido.',


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
        'alpha_space' => 'Il campo :attribute contiene un carattere non consentito.',
        'email_array'      => 'Uno o più indirizzi email non sono validi.',
        'hashed_pass'      => 'La tua attuale password non è corretta',
        'dumbpwd'          => 'Questa password è troppo comune.',
        'statuslabel_type' => 'È necessario selezionare un tipo di etichetta di stato valido',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute deve essere in formato AAAA-MM-GG',
        'last_audit_date.date_format'   =>  ':attribute deve essere in formato AAAA-MM-GG hh:mm:ss',
        'expiration_date.date_format'   =>  ':attribute deve essere in formato AAAA-MM-GG',
        'termination_date.date_format'  =>  ':attribute deve essere in formato AAAA-MM-GG',
        'expected_checkin.date_format'  =>  ':attribute deve essere in formato AAAA-MM-GG',
        'start_date.date_format'        =>  ':attribute deve essere in formato AAAA-MM-GG',
        'end_date.date_format'          =>  ':attribute deve essere in formato AAAA-MM-GG',

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

    /*
    |--------------------------------------------------------------------------
    | Generic Validation Messages
    |--------------------------------------------------------------------------
    */
    'invalid_value_in_field' => 'Valore non valido incluso in questo campo',
];
