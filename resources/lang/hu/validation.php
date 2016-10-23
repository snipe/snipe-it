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

    "accepted"         => "A :attribute el kell fogadni.",
    "active_url"       => "A :attribute nem valós URL.",
    "after"            => "Az :attribute ezután a dátum után kell, hogy legyen :date.",
    "alpha"            => "A :attribute csak betűket tartalmazhat.",
    "alpha_dash"       => "A :attribute csak betűket, számokat és perjelet tartalmazhat.",
    "alpha_num"        => "A :attribute csak betűket, számokat tartalmazhat.",
    "before"           => "A :attribute csak :date elötti dátum lehet.",
    "between"          => array(
        "numeric" => "A :attribute az érték között kell lennie :min -:max.",
        "file"    => "A :attribute :min - :max kilobájt között kell lenni.",
        "string"  => "A :attribute :min - :max karakter között kell lenni.",
    ),
    "confirmed"        => "A :attribute ellenörzés nem egyezik.",
    "date"             => "A :attribute nem egy valós dátum.",
    "date_format"      => "A :attribute nem egyezik a formátummal :format.",
    "different"        => "A :attribute és :other különböznie kell.",
    "digits"           => "A :attribute :digits számjegynek kell lenni.",
    "digits_between"   => "A :attribute :min - :max számjegy között kell lenni.",
    "email"            => "Az :attribute formátuma érvénytelen.",
    "exists"           => "A kiválasztott :attribute étvénytelen.",
    "email_array"      => "Egy vagy több email cím érvénytelen.",
    "image"            => "A :attribute képnek kell lenni.",
    "in"               => "A kiválasztott :attribute étvénytelen.",
    "integer"          => "A :attribute számnak kell lennie.",
    "ip"               => "A :attribute érvényes IP címnek kell lenni.",
    "max"              => array(
        "numeric" => "A :attribute nem lehet nagyobb, mint :max.",
        "file"    => "A :attribute nem lehet nagyobb, mint :max kilobájt.",
        "string"  => "A :attribute nem lehet nagyobb, mint :max karakter.",
    ),
    "mimes"            => "A :attribute ilyen fájl típusnak kell lennie: :values.",
    "min"              => array(
        "numeric" => "A :attribute legalább :min kell lenni.",
        "file"    => "A :attribute legalább :min kilobájt kell lenni.",
        "string"  => "A :attribute legalább :min karakter kell lenni.",
    ),
    "not_in"           => "A kiválasztott :attribute étvénytelen.",
    "numeric"          => "A :attribute csak szám lehet.",
    "regex"            => "Az :attribute formátuma érvénytelen.",
    "required"         => "A :attribute mező kötelező.",
    "required_if"      => "A :attribute mező kötelező ha :other egy :value.",
    "required_with"    => "A :attribute mező kötelező ha :value jelen van.",
    "required_without" => "A :attribute mező kötelező ha :value nincs jelen.",
    "same"             => "A :attribute és :other egyeznie kell.",
    "size"             => array(
        "numeric" => "A :attribute kötelező mérete :size.",
        "file"    => "A :attribute kötelező mérete :size kilobájt.",
        "string"  => "A :attribute kötelező mérete :size karakter.",
    ),
    "unique"           => "A :attribute már foglalt.",
    "url"              => "Az :attribute formátuma érvénytelen.",
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
    'alpha_space' => "A :attribute mező tartalmaz egy érvénytelen karaktert.",

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
