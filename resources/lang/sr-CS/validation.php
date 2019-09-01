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

    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => ':attribute nije važeći URL.',
    'after'                => ':attribute mora biti datum nakon :datum.',
    'after_or_equal'       => ':attribute mora biti datum nakon ili jednak :date.',
    'alpha'                => ':attribute može sadržavati samo slova.',
    'alpha_dash'           => ':attribute može sadržavati samo slova, brojeve i crtice.',
    'alpha_num'            => ':attribute može sadržavati samo slova i brojeve.',
    'array'                => ':attribute mora biti niz.',
    'before'               => ':attribute mora biti datum pre :date.',
    'before_or_equal'      => ':attribute mora biti datum pre ili jednak :date.',
    'between'              => [
        'numeric' => ':attribute mora biti između :min - :max.',
        'file'    => ':attribute mora biti između :min i :max kilobajta.',
        'string'  => ':attribute mora biti između :min i :max znakova.',
        'array'   => ':attribute mora imati između :min i :max stavki.',
    ],
    'boolean'              => ':attribute mora biti true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => ':attribute nije ispravan datum.',
    'date_format'          => ':attribute ne odgovara formatu :format.',
    'different'            => ':attributei i :other moraju biti različiti.',
    'digits'               => ':attribute mora biti :digits brojevi.',
    'digits_between'       => ':attribute mora biti između :min i :max cifara.',
    'dimensions'           => ':attribute ima pogrešnu dimenzije slike.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute format pogrešan.',
    'exists'               => 'Odabrani :attribute nije korektan.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => ':attribute mora imati vrednost.',
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'Odabrani :attribute nije korektan.',
    'in_array'             => ':attribute polje ne postoji u :other.',
    'integer'              => ':attribute mora biti ceo broj.',
    'ip'                   => ':attribute mora biti važeća IP adresa.',
    'ipv4'                 => ':attribute mora biti važeća IPv4 adresa.',
    'ipv6'                 => ':attribute mora biti važeća IPv6 adresa.',
    'json'                 => ':attribute mora biti ispravan JSON niz.',
    'max'                  => [
        'numeric' => ':attribute ne sme biti veći od :max.',
        'file'    => ':attribute ne sme biti veći od : max. kilobajta.',
        'string'  => ':attribute ne sme biti veći od :max znakova.',
        'array'   => ':attribute ne sme imati više od :max stavki.',
    ],
    'mimes'                => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes'            => ':attribute mora biti datoteka tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file'    => ':attribute mora biti najmanje :min kilobajta.',
        'string'  => ':attribute mora biti najmanje :min znakova.',
        'array'   => ':attribute mora imati barem :min stavke.',
    ],
    'not_in'               => 'Odabrani :attribute nije ispravan.',
    'numeric'              => ':attribute mora biti broj.',
    'present'              => ':attribute polje mora biti prisutno.',
    'valid_regex'          => 'To nije valjani regex. ',
    'regex'                => ':attribute format nije ispravan.',
    'required'             => ':attribute polje je obavezno.',
    'required_if'          => ':attribute polje je obavezno kada je :other :value.',
    'required_unless'      => ':attribute polje je obavezno unless :other is in :values.',
    'required_with'        => ':attribute polje je obavezno kada postoji :values.',
    'required_with_all'    => ':attribute polje je obavezno kada :values postoji.',
    'required_without'     => ':attribute polje je obavezno kada :values ne postoji.',
    'required_without_all' => ':attribute polje je obavezno ako nijedna od :values nije prisutna.',
    'same'                 => ':attribute i :other moraju da su isti.',
    'size'                 => [
        'numeric' => ':attribute mora biti :size.',
        'file'    => ':attribute mora biti :size kilobajta.',
        'string'  => ':attribute mora biti :size znakova.',
        'array'   => ':attribute mora sadržavati :size stavki.',
    ],
    'string'               => ':attribute mora biti :string.',
    'timezone'             => ':attribute mora biti ispravna zona.',
    'unique'               => ':attribute je već zauzet.',
    'uploaded'             => ':attribute nije prenet.',
    'url'                  => ':attribute format je neispravan.',
    "unique_undeleted"     => ":attribute mora biti jedinstven.",

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
        'alpha_space' => ":attribute polje sadrži znak koji nije dozvoljen.",
        "email_array"      => "Jedna ili više email adresa nisu ispravne.",
        "hashed_pass"      => "Vaša lozinka je neispravna",
        'dumbpwd'          => 'Lozinka nije sigurna.',
        "statuslabel_type" => "Morate odabrati ispravnu vrstu oznake statusa",
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
