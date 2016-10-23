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

    "accepted"         => "Je potřeba potvrdit :attribute.",
    "active_url"       => ":attribute není platnou URL.",
    "after"            => ":attribute nemůže být dříve než :date.",
    "alpha"            => ":attribute může obsahovat pouze písmena.",
    "alpha_dash"       => ":attribute může obsahovat pouze písmena, čísla, a pomlčky.",
    "alpha_num"        => ":attribute může obsahovat pouze písmena čísla.",
    "before"           => ":attribute nemůže být později než :date.",
    "between"          => array(
        "numeric" => ":attribute musí být mezi :min - :max.",
        "file"    => ":attribute musí být mezi :min - :max kilobajtů.",
        "string"  => ":attribute smí obsahovat pouze :min - :max znaků.",
    ),
    "confirmed"        => "Potvrzení :attribute se neshoduje.",
    "date"             => ":attribute není platným datem.",
    "date_format"      => "Atribut  :attribute nesouhlasí s formátem :format.",
    "different"        => ":attribute a  :other se musí lišit.",
    "digits"           => ":attribute musí být :digits číslo.",
    "digits_between"   => ":attribute musí být mezi hodnotami :min a :max.",
    "email"            => "Formát :attribute je neplatný.",
    "exists"           => "Zvolený :attribute je neplatný.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute musí být obrázek.",
    "in"               => "Zvolený :attribute je neplatný.",
    "integer"          => ":attribute musí být celočíselný.",
    "ip"               => ":attribute musí být platná IP adresa.",
    "max"              => array(
        "numeric" => ":attribute nesmí být větší než :max.",
        "file"    => ":attribute nesmí být větší než :max kilobajtů.",
        "string"  => ":attribute nesmí být větší než :max znaků.",
    ),
    "mimes"            => ":attribute musí být soubor typu: :values.",
    "min"              => array(
        "numeric" => ":attribute musí být minimálne :min.",
        "file"    => ":attribute musí být minimálně :min kilobajtů.",
        "string"  => ":attribute musí mít minimálně :min znaků.",
    ),
    "not_in"           => "Zvolený :attribute je neplatný.",
    "numeric"          => ":attribute musí být číslo.",
    "regex"            => "Formát :attribute je neplatný.",
    "required"         => "Pole :attribute je požadováno.",
    "required_if"      => "Položka :attribute je vyžadována, když :other je :value.",
    "required_with"    => "Hodnota :attribute je vyžadována, když je přítomno :values.",
    "required_without" => "Hodnota :attribute je vyžadována, když není přítomno :values.",
    "same"             => ":attribute a :other se musí shodovat.",
    "size"             => array(
        "numeric" => ":attribute musí být :size.",
        "file"    => ":attribute musí být :size kilobajtů.",
        "string"  => ":attribute musí mít :size znaků.",
    ),
    "unique"           => ":attribute byl již vybrán.",
    "url"              => "Formát :attribute je neplatný.",
    "statuslabel_type" => "You must select a valid status label type",
    "unique_undeleted" => "The :attribute must be unique.",


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

    'custom' => array(),
    'alpha_space' => "Pole :attribute obsahuje nepovolené znaky.",

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

    'attributes' => array(),

);
