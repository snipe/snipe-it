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

    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => 'The: atribut nije važeći URL.',
    'after'                => 'Atribut mora biti datum nakon: datum.',
    'after_or_equal'       => 'Atribut mora biti datum nakon ili jednak: datumu.',
    'alpha'                => 'Atribut može sadržavati samo slova.',
    'alpha_dash'           => 'Atribut može sadržavati samo slova, brojeve i crtice.',
    'alpha_num'            => 'Atribut može sadržavati samo slova i brojeve.',
    'array'                => 'Atribut mora biti niz.',
    'before'               => 'Atribut mora biti datum prije: datum.',
    'before_or_equal'      => 'Atribut mora biti datum prije ili jednak: datumu.',
    'between'              => [
        'numeric' => 'Atribut mora biti između: min i: max.',
        'file'    => 'Atribut mora biti između: min i: max kilobajta.',
        'string'  => 'Atribut mora biti između: min i: max znakova.',
        'array'   => 'Atribut mora imati između: min i: max stavki.',
    ],
    'boolean'              => 'Polje atributa mora biti točno ili netočno.',
    'confirmed'            => 'Potvrda atributa ne odgovara.',
    'date'                 => 'Atribut nije važeći datum.',
    'date_format'          => 'The: atribut ne odgovara formatu: format.',
    'different'            => 'Atribut: i drugi moraju biti različiti.',
    'digits'               => 'Atribut mora biti: znamenke znamenki.',
    'digits_between'       => 'Atribut mora biti između: min i: max znamenki.',
    'dimensions'           => 'The: atribut ima nevažeće dimenzije slike.',
    'distinct'             => 'Polje atributa ima duplikatu vrijednost.',
    'email'                => 'Atribut mora biti važeća adresa e-pošte.',
    'exists'               => 'Odabrani: atribut nije važeći.',
    'file'                 => 'The: atribut mora biti datoteka.',
    'filled'               => 'Polje atributa mora imati vrijednost.',
    'image'                => 'The: atribut mora biti slika.',
    'import_field_empty'    => 'The value for :fieldname cannot be null.',
    'in'                   => 'Odabrani: atribut nije važeći.',
    'in_array'             => 'Polje atributa ne postoji u: drugom.',
    'integer'              => 'Atribut mora biti cijeli broj.',
    'ip'                   => 'The: atribut mora biti važeća IP adresa.',
    'ipv4'                 => 'The: atribut mora biti važeća IPv4 adresa.',
    'ipv6'                 => 'The: atribut mora biti važeća IPv6 adresa.',
    'is_unique_department' => 'The :attribute must be unique to this Company Location',
    'json'                 => 'The: atribut mora biti valjan JSON niz.',
    'max'                  => [
        'numeric' => 'Atribut ne smije biti veći od: max.',
        'file'    => 'Atribut ne smije biti veći od: maks. Kilobajta.',
        'string'  => 'Atribut ne smije biti veći od: max znakova.',
        'array'   => 'The: atribut ne smije imati više od: max stavki.',
    ],
    'mimes'                => 'Atribut mora biti datoteka tipa:: vrijednosti.',
    'mimetypes'            => 'Atribut mora biti datoteka tipa:: vrijednosti.',
    'min'                  => [
        'numeric' => 'Atribut mora biti najmanje: min.',
        'file'    => 'Atribut mora biti najmanje: min kilobajta.',
        'string'  => 'Atribut mora biti najmanje: min znakova.',
        'array'   => 'Atribut mora imati barem: min stavke.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => 'Odabrani: atribut nije važeći.',
    'numeric'              => 'Atribut mora biti broj.',
    'present'              => 'Polje atributa mora biti prisutno.',
    'valid_regex'          => 'To nije valjani regex. ',
    'regex'                => 'Format atributa nije važeći.',
    'required'             => 'Potrebno je: polje atributa.',
    'required_if'          => 'Polje atributa je obavezno kada: druga vrijednost: vrijednost.',
    'required_unless'      => 'Polje atributa je obavezno, osim ako: druga nije u: vrijednostima.',
    'required_with'        => 'Polje atributa je obavezno kada: postoji vrijednost.',
    'required_with_all'    => 'Polje atributa je obavezno kada: postoji vrijednost.',
    'required_without'     => 'Polje atributa je potrebno kada: vrijednosti nisu prisutne.',
    'required_without_all' => 'Polje atributa je obavezno ako nijedna od: vrijednosti nije prisutna.',
    'same'                 => 'Atribut: i drugi moraju odgovarati.',
    'size'                 => [
        'numeric' => 'Atribut mora biti: veličina.',
        'file'    => 'Atribut mora biti: veličina kilobajta.',
        'string'  => 'The: atribut mora biti: veličina znakova.',
        'array'   => 'Atribut mora sadržavati: stavke veličine.',
    ],
    'string'               => 'The: atribut mora biti niz.',
    'timezone'             => 'Atribut mora biti važeća zona.',
    'unique'               => 'The: atribut je već snimljen.',
    'uploaded'             => 'Atribut nije prenesen.',
    'url'                  => 'Format atributa nije važeći.',
    'unique_undeleted'     => ':attribute mora biti jedinstven.',
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

    'custom' => [
        'alpha_space' => 'Polje atributa sadrži znak koji nije dopušten.',
        'email_array'      => 'Jedna ili više adresa e-pošte nije važeća.',
        'hashed_pass'      => 'Vaša trenutačna zaporka nije točna',
        'dumbpwd'          => 'Ta je lozinka prečestna.',
        'statuslabel_type' => 'Morate odabrati valjanu vrstu oznake statusa',

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
