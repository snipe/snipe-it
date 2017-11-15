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

    'accepted'             => 'A :attribute el kell fogadni.',
    'active_url'           => 'A :attribute nem valós URL.',
    'after'                => 'Az :attribute ezután a dátum után kell, hogy legyen :date.',
    'after_or_equal'       => 'A: attribútumnak dátumnak kell lennie, vagy egyenlőnek kell lennie: dátummal.',
    'alpha'                => 'A :attribute csak betűket tartalmazhat.',
    'alpha_dash'           => 'A :attribute csak betűket, számokat és perjelet tartalmazhat.',
    'alpha_num'            => 'A :attribute csak betűket, számokat tartalmazhat.',
    'array'                => 'A: attribútumnak tömbnek kell lennie.',
    'before'               => 'A :attribute csak :date elötti dátum lehet.',
    'before_or_equal'      => 'A: attribútumnak dátumnak kell lennie, vagy egyenlőnek kell lennie: dátummal.',
    'between'              => [
        'numeric' => 'A :attribute az érték között kell lennie :min -:max.',
        'file'    => 'A :attribute :min - :max kilobájt között kell lenni.',
        'string'  => 'A :attribute :min - :max karakter között kell lenni.',
        'array'   => 'A: attribútumnak rendelkeznie kell: min és max elem között.',
    ],
    'boolean'              => 'Az attribútumnak igaznak, vagy hamisnak kell lennie (true/false).',
    'confirmed'            => 'A :attribute ellenörzés nem egyezik.',
    'date'                 => 'A :attribute nem egy valós dátum.',
    'date_format'          => 'A :attribute nem egyezik a formátummal :format.',
    'different'            => 'A :attribute és :other különböznie kell.',
    'digits'               => 'A :attribute :digits számjegynek kell lenni.',
    'digits_between'       => 'A :attribute :min - :max számjegy között kell lenni.',
    'dimensions'           => 'A: attribútum érvénytelen képmérettel rendelkezik.',
    'distinct'             => 'A: attribútum mező duplikált értéket tartalmaz.',
    'email'                => 'Az :attribute formátuma érvénytelen.',
    'exists'               => 'A kiválasztott :attribute étvénytelen.',
    'file'                 => 'A: attribútumnak fájlnak kell lennie.',
    'filled'               => 'A: attribútum mezőnek értéket kell tartalmaznia.',
    'image'                => 'A :attribute képnek kell lenni.',
    'in'                   => 'A kiválasztott :attribute étvénytelen.',
    'in_array'             => 'A: attribútum mező nem létezik: más.',
    'integer'              => 'A :attribute számnak kell lennie.',
    'ip'                   => 'A :attribute érvényes IP címnek kell lenni.',
    'ipv4'                 => 'A: attribútumnak érvényes IPv4-címnek kell lennie.',
    'ipv6'                 => 'A: attribútumnak érvényes IPv6-címnek kell lennie.',
    'json'                 => 'A: attribútumnak érvényes JSON-karakterláncnak kell lennie.',
    'max'                  => [
        'numeric' => 'A :attribute nem lehet nagyobb, mint :max.',
        'file'    => 'A :attribute nem lehet nagyobb, mint :max kilobájt.',
        'string'  => 'A :attribute nem lehet nagyobb, mint :max karakter.',
        'array'   => 'A: attribútumnak nem lehet több: max eleme.',
    ],
    'mimes'                => 'A :attribute ilyen fájl típusnak kell lennie: :values.',
    'mimetypes'            => 'A: attribútumnak a következő típusú fájlnak kell lennie:: values.',
    'min'                  => [
        'numeric' => 'A :attribute legalább :min kell lenni.',
        'file'    => 'A :attribute legalább :min kilobájt kell lenni.',
        'string'  => 'A :attribute legalább :min karakter kell lenni.',
        'array'   => 'A: attribútumnak rendelkeznie kell legalább: min elemekkel.',
    ],
    'not_in'               => 'A kiválasztott :attribute étvénytelen.',
    'numeric'              => 'A :attribute csak szám lehet.',
    'present'              => 'A: attribútum mezőnek jelen kell lennie.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Az :attribute formátuma érvénytelen.',
    'required'             => 'A :attribute mező kötelező.',
    'required_if'          => 'A :attribute mező kötelező ha :other egy :value.',
    'required_unless'      => 'A: attribútummezőt csak akkor kell megadni, ha: az egyéb értéke: értéke.',
    'required_with'        => 'A :attribute mező kötelező ha :value jelen van.',
    'required_with_all'    => 'A: attribútum mező akkor szükséges, ha: értékek vannak jelen.',
    'required_without'     => 'A :attribute mező kötelező ha :value nincs jelen.',
    'required_without_all' => 'A: attribútummező akkor szükséges, ha egyik sem: értéke nincs.',
    'same'                 => 'A :attribute és :other egyeznie kell.',
    'size'                 => [
        'numeric' => 'A :attribute kötelező mérete :size.',
        'file'    => 'A :attribute kötelező mérete :size kilobájt.',
        'string'  => 'A :attribute kötelező mérete :size karakter.',
        'array'   => 'A: attribútumnak tartalmaznia kell: méretű elemeket.',
    ],
    'string'               => 'A: attribútumnak stringnek kell lennie.',
    'timezone'             => 'A: attribútumnak érvényes zónának kell lennie.',
    'unique'               => 'A :attribute már foglalt.',
    'uploaded'             => 'A: attribútum nem sikerült feltölteni.',
    'url'                  => 'Az :attribute formátuma érvénytelen.',
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
        'alpha_space' => "A: attribútum mező olyan karaktert tartalmaz, amely nem megengedett.",
        "email_array"      => "Egy vagy több e-mail cím érvénytelen.",
        "hashed_pass"      => "A jelenlegi jelszava helytelen",
        'dumbpwd'          => 'Ez a jelszó túl gyakori.',
        "statuslabel_type" => "Meg kell határoznia egy érvényes állapotcímke típust",
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
