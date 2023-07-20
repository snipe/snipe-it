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

    'accepted'             => ':attribute muss akzeptiert werden.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute muss ein Datum nach dem :date sein.',
    'after_or_equal'       => 'Das :attribute muss ein Datum nach oder gleich :date sein.',
    'alpha'                => ':attribute darf nur aus Buchstaben bestehen.',
    'alpha_dash'           => ':attribute darf nur aus Buchstaben, Zahlen und Gedankenstrichen bestehen.',
    'alpha_num'            => ':attribute darf nur aus Buchstaben und Zahlen bestehen.',
    'array'                => 'Das Attribut muss ein Array sein.',
    'before'               => ':attribute muss ein Datum vor dem :date sein.',
    'before_or_equal'      => 'Das Attribut muss ein Datum vor oder gleich: date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file'    => ':attribute darf nur zwischen :min und :max kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :min und maximal :max Zeichen enthalten.',
        'array'   => ':attribute muss mindestens :min und darf maximal :max Einträge haben.',
    ],
    'boolean'              => ':attribute muss wahr oder falsch sein.',
    'confirmed'            => ':attribute Bestätigung stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_format'          => ':attribute passt nicht zur :format Formatierung.',
    'different'            => ':attribute und :other müssen sich unterscheiden.',
    'digits'               => ':attribute muss :digits Stellen haben.',
    'digits_between'       => ':attribute soll mindestens :min und darf maximal :max Stellen haben.',
    'dimensions'           => ':attribute hat ein ungültiges Bildformat.',
    'distinct'             => 'Das Attributfeld hat einen doppelten Wert.',
    'email'                => 'Das Format von :attribute ist ungültig.',
    'exists'               => 'Das ausgewählte :attribute ist ungültig.',
    'file'                 => ':attribute muss eine Datei sein.',
    'filled'               => 'Das :attribute Feld muss einen Wert haben.',
    'image'                => ':attribute muss ein Bild sein.',
    'import_field_empty'    => ':fieldname darf nicht leer sein.',
    'in'                   => 'Auswahl :attribute ist ungültig.',
    'in_array'             => 'Das Feld :attribute existiert nicht in :other.',
    'integer'              => ':attribute muss eine ganze Zahl sein.',
    'ip'                   => ':attribute muss eine gültige IP Adresse sein.',
    'ipv4'                 => ':attribute muss eine gültige IPv4 Adresse sein.',
    'ipv6'                 => ':attribute muss eine gültige IPv6 Adresse sein.',
    'is_unique_department' => ':attribute muss einzigartig an diesem Standort sein',
    'json'                 => 'Das Attribut muss eine gültige JSON-Zeichenfolge sein.',
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf nicht größer als :max Kilobyte sein.',
        'string'  => ':attribute darf nicht mehr als :max Zeichen sein.',
        'array'   => 'Das: -Attribut darf nicht mehr als: maximale Elemente haben.',
    ],
    'mimes'                => ':attribute muss eine Datei des Typs :values sein.',
    'mimetypes'            => ':attribute muss eine Datei vom Typ: :values sein.',
    'min'                  => [
        'numeric' => ':attribute muss kleiner als :min sein.',
        'file'    => ':attribute muss mindestens :min Kilobyte groß sein.',
        'string'  => ':attribute benötigt mindestens :min Zeichen.',
        'array'   => ':attribute muss mindestens :min Elemente enthalten.',
    ],
    'starts_with'          => ':attribute muss mit einem der folgenden Werte beginnen: :values.',
    'ends_with'            => ':attribute muss mit einem der folgenden Werte enden: :values.',

    'not_in'               => 'Auswahl :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Zahl sein.',
    'present'              => ':attribute muss vorhanden sein.',
    'valid_regex'          => 'Dies ist kein gültiger Regex-Ausdruck. ',
    'regex'                => ':attribute Format ungültig.',
    'required'             => ':attribute Feld muss ausgefüllt sein.',
    'required_if'          => ':attribute wird benötigt, wenn :other :value entspricht.',
    'required_unless'      => ':attribute ist erforderlich, es sei denn :other ist in :values.',
    'required_with'        => ':attribute wird benötigt wenn :value ausgewählt ist.',
    'required_with_all'    => ':attribute field ist erforderlich, wenn :values vorhanden sind.',
    'required_without'     => ':attribute wird benötigt wenn :value nicht ausgewählt ist.',
    'required_without_all' => 'Das: Attributfeld ist erforderlich, wenn keine der folgenden Werte vorhanden sind:',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss :size groß sein.',
        'file'    => ':attribute muss :size Kilobyte groß sein.',
        'string'  => ':attribute muss :size Zeichen haben.',
        'array'   => 'Das Attribut muss Folgendes enthalten: Größenelemente.',
    ],
    'string'               => 'Das Attribut muss eine Zeichenfolge sein.',
    'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
    'unique'               => ':attribute schon benutzt.',
    'uploaded'             => ':attribute konnte nicht hochgeladen werden.',
    'url'                  => ':attribute Format ist ungültig.',
    'unique_undeleted'     => 'Die Variable :attribute muss eindeutig sein.',
    'non_circular'         => 'Das :attribute darf keinen Zirkelbezug ergeben.',
    'disallow_same_pwd_as_user_fields' => 'Das Passwort muss sich vom Nutzernamen unterscheiden.',
    'letters'              => 'Das Passwort muss mindestens einen Buchstaben beinhalten.',
    'numbers'              => 'Das Passwort muss mindestens eine Zahl beinhalten.',
    'case_diff'            => 'Das Passwort muss Groß- und Kleinschreibung beinhalten.',
    'symbols'              => 'Das Passwort muss Sonderzeichen beinhalten.',
    'gte'                  => [
        'numeric'          => 'Wert darf nicht negativ sein'
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

    'custom' => [
        'alpha_space' => 'Das :attribute Feld enthält ein nicht erlaubtes Zeichen.',
        'email_array'      => 'Eine oder mehrere Email Adressen sind ungültig.',
        'hashed_pass'      => 'Ihr derzeitiges Passwort ist nicht korrekt',
        'dumbpwd'          => 'Das Passwort ist zu gebräuchlich.',
        'statuslabel_type' => 'Sie müssen einen gültigen Statuslabel-Typ auswählen',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',
        'last_audit_date.date_format'   =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT hh:mm:ss sein',
        'expiration_date.date_format'   =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',
        'termination_date.date_format'  =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',
        'expected_checkin.date_format'  =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',
        'start_date.date_format'        =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',
        'end_date.date_format'          =>  ':attribute muss ein gültiges Datum im Format JJJJ-MM-TT sein',

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
