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

    'accepted'             => 'Atribut mora biti sprejet.',
    'active_url'           => 'Atribut ni veljaven URL.',
    'after'                => 'Atribut mora biti datum po: datumu.',
    'after_or_equal'       => 'Atribut mora biti datum po ali enak: datumu.',
    'alpha'                => 'Atribut lahko vsebuje le črke.',
    'alpha_dash'           => 'Atribut lahko vsebuje samo črke, številke in pomišljaje.',
    'alpha_num'            => 'Atribut lahko vsebuje le črke in številke.',
    'array'                => 'Atribut mora biti matrika.',
    'before'               => 'Atribut mora biti datum pred: datum.',
    'before_or_equal'      => 'Atribut mora biti datum, ki je pred ali enakovreden datumu.',
    'between'              => [
        'numeric' => 'Atribut mora biti med: min -: max.',
        'file'    => 'Atribut mora biti med: min -: max kilobajtov.',
        'string'  => 'Atribut mora biti med: min -: max znakov.',
        'array'   => 'Atribut mora imeti med: min in: max elementov.',
    ],
    'boolean'              => 'Atribut mora biti true ali false.',
    'confirmed'            => 'Potrditev atributa se ne ujema.',
    'date'                 => 'Atribut ni veljaven datum.',
    'date_format'          => 'Atribut se ne ujema z obliko: format.',
    'different'            => 'Atribut: drugi mora biti drugačen.',
    'digits'               => 'Atribut mora biti: števnik.',
    'digits_between'       => 'Atribut mora biti med: min in: max števkami.',
    'dimensions'           => 'Atribut ima neveljavne dimenzije slike.',
    'distinct'             => 'Polje atribut ima podvojeno vrednost.',
    'email'                => 'Oblika atributa je neveljavna.',
    'exists'               => 'Izbrani atribut je neveljaven.',
    'file'                 => 'Atribut mora biti datoteka.',
    'filled'               => 'Polje atribut mora imeti vrednost.',
    'image'                => 'Atribut mora biti slika.',
    'in'                   => 'Izbrani atribut je neveljaven.',
    'in_array'             => 'Polje atributov ne obstaja v: drugem.',
    'integer'              => 'Atribut mora biti celo število.',
    'ip'                   => 'Atribut mora biti veljaven IP-naslov.',
    'ipv4'                 => 'Atribut mora biti veljaven IPv4 naslov.',
    'ipv6'                 => 'Atribut mora biti veljaven IPv6 naslov.',
    'json'                 => 'Atribut mora biti veljaven JSON niz.',
    'max'                  => [
        'numeric' => 'Atribut ne sme biti večji od: max.',
        'file'    => 'Atribut ne sme biti večji od: max kilobajtov.',
        'string'  => 'Atribut ne sme biti večji od: max znakov.',
        'array'   => 'Atribut ne sme vsebovati več kot: max elementov.',
    ],
    'mimes'                => 'Atribut mora biti datoteka vrste:: vrednost.',
    'mimetypes'            => 'Atribut mora biti datoteka vrste:: vrednosti.',
    'min'                  => [
        'numeric' => 'Atribut mora biti vsaj: min.',
        'file'    => 'Atribut mora biti vsaj: min kilobajtov.',
        'string'  => 'Atribut mora biti vsaj: min znakov.',
        'array'   => 'Atribut mora imeti vsaj: min elementov.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Izbrani atribut je neveljaven.',
    'numeric'              => 'Atribut mora biti število.',
    'present'              => 'Polje atribut mora biti prisotno.',
    'valid_regex'          => 'To ni veljaven regex. ',
    'regex'                => 'Oblika atributa je neveljavna.',
    'required'             => 'Polje ne sme biti prazno.',
    'required_if'          => 'Polje atributa je obvezno, če: drugo je: vrednost.',
    'required_unless'      => 'Polje atributa je obvezno, razen če je: drugo v: vrednosti.',
    'required_with'        => 'Polje atributa je obvezno, ko: so prisotne vrednosti.',
    'required_with_all'    => 'Polje atributa je obvezno, ko: so prisotne vrednosti.',
    'required_without'     => 'Polje atributa je obvezno, če: vrednosti niso prisotne.',
    'required_without_all' => 'Polje atributa je obvezno, če nobena od: vrednosti ni prisotna.',
    'same'                 => 'Atribut in: drugi se morajo ujemati.',
    'size'                 => [
        'numeric' => 'Atribut mora biti: velikost.',
        'file'    => 'Atribut mora biti: velikost kilobajtov.',
        'string'  => 'Atribut mora biti: velikost znakov.',
        'array'   => 'Atribut mora vsebovati: elemente velikosti.',
    ],
    'string'               => 'Atribut mora biti niz.',
    'timezone'             => 'Atribut mora biti veljavno območje.',
    'unique'               => 'Atribut je bil že sprejet.',
    'uploaded'             => 'Atribut se ni uspel naložiti.',
    'url'                  => 'Oblika atributa je neveljavna.',
    'unique_undeleted'     => 'Atribut mora biti edinstven.',
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
        'alpha_space' => 'Polje atributa vsebuje znak, ki ni dovoljen.',
        'email_array'      => 'En ali več e-poštnih naslovov je napačnih.',
        'hashed_pass'      => 'Vaše trenutno geslo je napačno',
        'dumbpwd'          => 'To geslo je preveč pogosto.',
        'statuslabel_type' => 'Izbrati morate veljavn status oznake',
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
