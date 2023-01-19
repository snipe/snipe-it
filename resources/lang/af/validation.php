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

    'accepted'             => 'Die: Attribuut moet aanvaar word.',
    'active_url'           => 'Die: Attribuut is nie \'n geldige URL nie.',
    'after'                => 'Die: Attribuut moet \'n datum wees na: datum.',
    'after_or_equal'       => 'Die: Attribuut moet \'n datum na of gelyk wees aan: datum.',
    'alpha'                => 'Die: Attribuut mag slegs letters bevat.',
    'alpha_dash'           => 'Die: Attribuut mag slegs letters, nommers en streepies bevat.',
    'alpha_num'            => 'Die: Attribuut mag slegs letters en syfers bevat.',
    'array'                => 'Die: kenmerk moet \'n skikking wees.',
    'before'               => 'Die: Attribuut moet \'n datum wees voor: datum.',
    'before_or_equal'      => 'Die: Attribuut moet \'n datum voor of gelyk wees aan: datum.',
    'between'              => [
        'numeric' => 'Die: Attribuut moet tussen: min en: maksimum wees.',
        'file'    => 'Die: Attribuut moet tussen: min en: maksimum kilobytes wees.',
        'string'  => 'Die: Attribuut moet tussen: min en: maksimum karakters wees.',
        'array'   => 'Die: Attribuut moet tussen: min en: maksimum items hê.',
    ],
    'boolean'              => 'Die: Attribuut veld moet waar of onwaar wees.',
    'confirmed'            => 'Die: Attribuut bevestiging stem nie ooreen nie.',
    'date'                 => 'Die: Attribuut is nie \'n geldige datum nie.',
    'date_format'          => 'Die: Attribuut stem nie ooreen met die formaat: formaat.',
    'different'            => 'Die: attribuut en: ander moet anders wees.',
    'digits'               => 'Die: Attribuut moet wees: syfers syfers.',
    'digits_between'       => 'Die: Attribuut moet tussen: min en: maksimum syfers wees.',
    'dimensions'           => 'Die: Attribuut het ongeldige beeldafmetings.',
    'distinct'             => 'Die: Attribuut veld het \'n duplikaat waarde.',
    'email'                => 'Die: Attribuut moet \'n geldige e-posadres wees.',
    'exists'               => 'Die gekose: attribuut is ongeldig.',
    'file'                 => 'Die: Attribuut moet \'n lêer wees.',
    'filled'               => 'Die: Attribuut veld moet \'n waarde hê.',
    'image'                => 'Die: kenmerk moet \'n beeld wees.',
    'in'                   => 'Die gekose: attribuut is ongeldig.',
    'in_array'             => 'Die: attribuut veld bestaan ​​nie in: ander.',
    'integer'              => 'Die: Attribuut moet \'n heelgetal wees.',
    'ip'                   => 'Die: Attribuut moet \'n geldige IP-adres wees.',
    'ipv4'                 => 'Die: Attribuut moet \'n geldige IPv4-adres wees.',
    'ipv6'                 => 'Die: Attribuut moet \'n geldige IPv6-adres wees.',
    'json'                 => 'Die: Attribuut moet \'n geldige JSON-string wees.',
    'max'                  => [
        'numeric' => 'Die: Attribuut mag nie groter wees as: maksimum.',
        'file'    => 'Die: kenmerk mag nie groter wees as: maksimum kilobytes.',
        'string'  => 'Die: Attribuut mag nie groter wees as: maksimum karakters.',
        'array'   => 'Die: Attribuut mag nie meer as: maksimum items hê nie.',
    ],
    'mimes'                => 'Die: kenmerk moet \'n lêer van tipe wees:: waardes.',
    'mimetypes'            => 'Die: kenmerk moet \'n lêer van tipe wees:: waardes.',
    'min'                  => [
        'numeric' => 'Die: attribuut moet ten minste wees: min.',
        'file'    => 'Die: attribuut moet ten minste wees: min kilobytes.',
        'string'  => 'Die: kenmerk moet ten minste wees: min karakters.',
        'array'   => 'Die: Attribuut moet ten minste: min items hê.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Die gekose: attribuut is ongeldig.',
    'numeric'              => 'Die: Attribuut moet \'n nommer wees.',
    'present'              => 'Die: attribuut veld moet teenwoordig wees.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Die: Attribuutformaat is ongeldig.',
    'required'             => 'Die: attribuut veld is nodig.',
    'required_if'          => 'Die: attribuut veld is nodig wanneer: ander is: waarde.',
    'required_unless'      => 'Die: Attribuut veld is nodig tensy: ander is in: waardes.',
    'required_with'        => 'Die: Attribuut veld is nodig wanneer: waardes teenwoordig is.',
    'required_with_all'    => 'Die: Attribuut veld is nodig wanneer: waardes teenwoordig is.',
    'required_without'     => 'Die: Attribuut veld is nodig wanneer: waardes nie teenwoordig is nie.',
    'required_without_all' => 'Die: Attribuut veld is nodig wanneer geen van: waardes teenwoordig is nie.',
    'same'                 => 'Die: attribuut en ander moet ooreenstem.',
    'size'                 => [
        'numeric' => 'Die: Attribuut moet wees: grootte.',
        'file'    => 'Die: Attribuut moet wees: grootte kilobyte.',
        'string'  => 'Die: Attribuut moet wees: grootte karakters.',
        'array'   => 'Die: Attribuut moet bevat: grootte items.',
    ],
    'string'               => 'Die: kenmerk moet \'n string wees.',
    'timezone'             => 'Die: Attribuut moet \'n geldige sone wees.',
    'unique'               => 'Die: Attribuut is reeds geneem.',
    'uploaded'             => 'Die: kenmerk kon nie opgelaai word nie.',
    'url'                  => 'Die: Attribuutformaat is ongeldig.',
    'unique_undeleted'     => 'The :attribute must be unique.',
    'non_circular'         => 'The :attribute must not create a circular reference.',
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
        'alpha_space' => 'Die: attribuut veld bevat \'n karakter wat nie toegelaat word nie.',
        'email_array'      => 'Een of meer e-posadresse is ongeldig.',
        'hashed_pass'      => 'Jou huidige wagwoord is verkeerd',
        'dumbpwd'          => 'Daardie wagwoord is te algemeen.',
        'statuslabel_type' => 'U moet \'n geldige statusetiket tipe kies',
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
