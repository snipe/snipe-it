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

    'accepted'             => 'Attributtet :attribute må velges.',
    'active_url'           => 'Attributtet :attribute er ikke en gyldig URL.',
    'after'                => 'Attributtet :attribute må være en dato etter :date.',
    'after_or_equal'       => 'Attributtet :attribute må være en dato etter eller lik :date.',
    'alpha'                => 'Attributtet :attribute kan kun inneholde bokstaver.',
    'alpha_dash'           => 'Attributtet :attribute kan kun inneholde bokstaver, nummer eller bindestrek.',
    'alpha_num'            => 'Attributtet :attribute kan kun inneholde bokstaver og numre.',
    'array'                => 'Attributtet må være en matrise.',
    'before'               => 'Attributtet :attribute må være en dato før :date.',
    'before_or_equal'      => 'Attributtet :attribute må være en dato før eller lik :date.',
    'between'              => [
        'numeric' => 'Attributtet :attribute må være mellom :min og :max.',
        'file'    => 'Attributtet :attribute må være mellom :min og :max kilobytes.',
        'string'  => 'Attributtet :attribute må være mellom :min og :max tegn.',
        'array'   => 'Attributtet må ha mellom: min og: maks elementer.',
    ],
    'boolean'              => 'Attributtfeltet må være sant eller falskt.',
    'confirmed'            => 'Bekreftelse på attributtet :attribute stemmer ikke.',
    'date'                 => 'Attributtet :attribute er ikke en gyldig dato.',
    'date_format'          => 'Attributtet :attribute passer ikke formatet :format.',
    'different'            => 'Attributtet :attribute og :other er forskjellige.',
    'digits'               => 'Attributtet :attribute må være :digits sifre.',
    'digits_between'       => 'Attributtet :attribute må være mellom :min og :max sifre.',
    'dimensions'           => 'Attributtet har ugyldige bildedimensjoner.',
    'distinct'             => 'Attributtfeltet har en duplikatverdi.',
    'email'                => 'Attributtet :attribute er ugyldig.',
    'exists'               => 'Valgt attributt :attribute er ugyldig.',
    'file'                 => 'Attributtet :attribute må være en fil.',
    'filled'               => 'Den :attribute må ha en verdi.',
    'image'                => 'Attributtet :attribute må være et bilde.',
    'import_field_empty'    => 'The value for :fieldname cannot be null.',
    'in'                   => 'Det valgte attributtet :attribute er ugyldig.',
    'in_array'             => 'Attributtfeltet finnes ikke i: andre.',
    'integer'              => 'Attributtet :attribute må være et heltall.',
    'ip'                   => 'Attributtet :attribute må være en gyldig IP-adresse.',
    'ipv4'                 => 'Attributtet :attribute må være en gyldig IPv4-adresse.',
    'ipv6'                 => 'Attributtet :attribute må være en gyldig IPv6-adresse.',
    'is_unique_department' => 'The :attribute must be unique to this Company Location',
    'json'                 => 'Attributtet: må være en gyldig JSON-streng.',
    'max'                  => [
        'numeric' => 'Attributtet :attribute må ikke være større enn :max.',
        'file'    => 'Attributtet :attribute kan ikke være større enn :max kilobytes.',
        'string'  => 'Attributtet :attribute kan ikke være større enn :max tegn.',
        'array'   => 'Attributtet: Må ikke ha mer enn: maks. Elementer.',
    ],
    'mimes'                => 'Attributtet :attribute må være en fil av typen: :values.',
    'mimetypes'            => 'Attributtet må være en fil av type:: verdier.',
    'min'                  => [
        'numeric' => 'Attributtet :attribute må være minst :min.',
        'file'    => 'Attributtet :attribute må være minst :min kilobytes.',
        'string'  => 'Attributtet :attribute må være minst :min tegn.',
        'array'   => 'Attributtet må ha minst: min elementer.',
    ],
    'starts_with'          => ':attribute må starte med en av følgende: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => 'Attributtet :attribute er ugyldig.',
    'numeric'              => 'Attributtet :attribute må være et nummer.',
    'present'              => 'Atributtfeltet :attribute må ha en verdi.',
    'valid_regex'          => 'Det er ikke en gyldig regex. ',
    'regex'                => 'Attributt-formatet til :attribute er ugyldig.',
    'required'             => 'Attributt-feltet :attribute er påkrevd.',
    'required_if'          => 'Attributt-feltet :attribute er påkrevd når :oher er :value.',
    'required_unless'      => 'Attributtfeltet kreves med mindre: annet er i: verdier.',
    'required_with'        => 'Attributt-feltet :attribute er påkrevd når :values er tilstede.',
    'required_with_all'    => 'Attributtfeltet kreves når: verdiene er til stede.',
    'required_without'     => 'Attributt-feltet :attribute er påkrevd når :values ikke er tilstede.',
    'required_without_all' => 'Attributtfeltet kreves når ingen av: verdiene er til stede.',
    'same'                 => 'Attributtet :attribute og :other må være like.',
    'size'                 => [
        'numeric' => 'Attributtet :attribute må være :size.',
        'file'    => 'Attributtet :attribute må være :size kilobytes.',
        'string'  => 'Attributtet :attribute må være :size tegn.',
        'array'   => 'Attributtet må inneholde: størrelseselementer.',
    ],
    'string'               => 'Attributtet :attribute må være en tekst.',
    'timezone'             => 'Attributtet må være en gyldig sone.',
    'unique'               => 'Attributtet :attribute er allerede tatt.',
    'uploaded'             => 'Atribbutet :attribute kunne ikke lastes opp.',
    'url'                  => 'Attributt-formatet :attribute er ugyldig.',
    'unique_undeleted'     => ':attribute må være unikt.',
    'non_circular'         => 'Attributtet :attribute kan ikke opprette en sirkulær referanse.',
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

    'custom' => [
        'alpha_space' => 'Attributtfeltet inneholder et tegn som ikke er tillatt.',
        'email_array'      => 'En eller flere e-postadresser er ugyldige.',
        'hashed_pass'      => 'Gjeldende passord er feil',
        'dumbpwd'          => 'Passordet er for vanlig.',
        'statuslabel_type' => 'Du må velge en gyldig statusetikett-type',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => 'The :attribute must be a valid date in YYYY-MM-DD format',
        'last_audit_date.date_format'   =>  'The :attribute must be a valid date in YYYY-MM-DD hh:mm:ss format',
        'expiration_date.date_format'   =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'termination_date.date_format'  =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'expected_checkin.date_format'  =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'start_date.date_format'        =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'end_date.date_format'          =>  'The :attribute must be a valid date in YYYY-MM-DD format',

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
