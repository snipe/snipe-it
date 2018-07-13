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

    'accepted'             => 'Je potřeba potvrdit :attribute.',
    'active_url'           => ':attribute není platnou URL.',
    'after'                => ':attribute nemůže být dříve než :date.',
    'after_or_equal'       => 'Atribut musí mít datum následující nebo rovné: datum.',
    'alpha'                => ':attribute může obsahovat pouze písmena.',
    'alpha_dash'           => ':attribute může obsahovat pouze písmena, čísla, a pomlčky.',
    'alpha_num'            => ':attribute může obsahovat pouze písmena čísla.',
    'array'                => 'Atribut musí být atribut.',
    'before'               => ':attribute nemůže být později než :date.',
    'before_or_equal'      => 'Atribut: musí mít datum před datem nebo se rovnat: datum.',
    'between'              => [
        'numeric' => ':attribute musí být mezi :min - :max.',
        'file'    => ':attribute musí být mezi :min - :max kilobajtů.',
        'string'  => ':attribute smí obsahovat pouze :min - :max znaků.',
        'array'   => 'Atribut: musí obsahovat položky: min a max.',
    ],
    'boolean'              => ':attribute musí být true nebo false.',
    'confirmed'            => 'Potvrzení :attribute se neshoduje.',
    'date'                 => ':attribute není platným datem.',
    'date_format'          => 'Atribut  :attribute nesouhlasí s formátem :format.',
    'different'            => ':attribute a  :other se musí lišit.',
    'digits'               => ':attribute musí být :digits číslo.',
    'digits_between'       => ':attribute musí být mezi hodnotami :min a :max.',
    'dimensions'           => 'Atribut: má neplatné kóty obrázku.',
    'distinct'             => 'Pole atributu: atribut má duplicitní hodnotu.',
    'email'                => 'Formát :attribute je neplatný.',
    'exists'               => 'Zvolený :attribute je neplatný.',
    'file'                 => 'Atribut: musí být soubor.',
    'filled'               => 'Pole atributu: musí mít hodnotu.',
    'image'                => ':attribute musí být obrázek.',
    'in'                   => 'Zvolený :attribute je neplatný.',
    'in_array'             => 'Pole atributu neexistuje v: jiné.',
    'integer'              => ':attribute musí být celočíselný.',
    'ip'                   => ':attribute musí být platná IP adresa.',
    'ipv4'                 => 'Atribut: musí mít platnou adresu IPv4.',
    'ipv6'                 => 'Atribut: musí být platná adresa IPv6.',
    'json'                 => 'Atribut: musí být platný řetězec JSON.',
    'max'                  => [
        'numeric' => ':attribute nesmí být větší než :max.',
        'file'    => ':attribute nesmí být větší než :max kilobajtů.',
        'string'  => ':attribute nesmí být větší než :max znaků.',
        'array'   => 'Atribut: Atribut nesmí mít více než: max položky.',
    ],
    'mimes'                => ':attribute musí být soubor typu: :values.',
    'mimetypes'            => 'Atribut: musí být soubor typu:: values.',
    'min'                  => [
        'numeric' => ':attribute musí být minimálne :min.',
        'file'    => ':attribute musí být minimálně :min kilobajtů.',
        'string'  => ':attribute musí mít minimálně :min znaků.',
        'array'   => 'Atribut musí mít alespoň: min položky.',
    ],
    'not_in'               => 'Zvolený :attribute je neplatný.',
    'numeric'              => ':attribute musí být číslo.',
    'present'              => 'Pole atributu musí být přítomno.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Formát :attribute je neplatný.',
    'required'             => 'Pole :attribute je požadováno.',
    'required_if'          => 'Položka :attribute je vyžadována, když :other je :value.',
    'required_unless'      => 'Pole atributu: je povinné, pokud: jiný není v: hodnoty.',
    'required_with'        => 'Hodnota :attribute je vyžadována, když je přítomno :values.',
    'required_with_all'    => 'Pole atributu: je požadováno, když: jsou přítomny hodnoty.',
    'required_without'     => 'Hodnota :attribute je vyžadována, když není přítomno :values.',
    'required_without_all' => 'Pole atributu: je vyžadováno, pokud nejsou žádné hodnoty: existují.',
    'same'                 => ':attribute a :other se musí shodovat.',
    'size'                 => [
        'numeric' => ':attribute musí být :size.',
        'file'    => ':attribute musí být :size kilobajtů.',
        'string'  => ':attribute musí mít :size znaků.',
        'array'   => 'Atribut: musí obsahovat: položky velikosti.',
    ],
    'string'               => 'Atribut: musí být řetězec.',
    'timezone'             => 'Atribut: musí být platnou zónou.',
    'unique'               => ':attribute byl již vybrán.',
    'uploaded'             => 'Atribut: se nepodařilo nahrát.',
    'url'                  => 'Formát :attribute je neplatný.',
    "unique_undeleted"     => "The :attribute must be unique.",

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
        'alpha_space' => "Pole atributu: atribut obsahuje znak, který není povolen.",
        "email_array"      => "Jedna nebo více e-mailových adres je neplatná.",
        "hashed_pass"      => "Vaše současné heslo je nesprávné",
        'dumbpwd'          => 'Toto heslo je příliš běžné.',
        "statuslabel_type" => "Musíte vybrat platný typ štítku stavu",
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
