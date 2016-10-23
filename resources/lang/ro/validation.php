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

    "accepted"         => ":attribute a fost acceptat.",
    "active_url"       => ":attribute nu este un URL valid.",
    "after"            => ":attribute trebuie sa fie o data dupa :date.",
    "alpha"            => ":attribute trebuie sa contina numai litere.",
    "alpha_dash"       => ":attribute poate sa contina numai litere, cifre si linia de punctuatie.",
    "alpha_num"        => ":attribute poate sa contina numai litere si cifre.",
    "before"           => ":attribute trebuie sa contina o data inainte de :date.",
    "between"          => array(
        "numeric" => ":attribute trebuie sa fie intre :min - :max.",
        "file"    => ":attribute trebuie sa fie intre  :min - :max kilobytes.",
        "string"  => ":attribute trebuie sa aiba intre :min - :max caractere.",
    ),
    "confirmed"        => "Confirmarea la :attribute nu este asemanatoare.",
    "date"             => ":attribute nu este o data.",
    "date_format"      => ":attribute nu se leaga cu formatul :format.",
    "different"        => ":attribute si :other trebuie sa fie diferite.",
    "digits"           => ":attribute trebuie sa fie de :digits cifre.",
    "digits_between"   => ":attribute trebuie sa fie intre :min si :max cifre.",
    "email"            => "Formatul :attribute nu este valid.",
    "exists"           => ":attribute selectat nu e valid.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute trebuie sa fie o imagine.",
    "in"               => ":attribute selectat nu este valid.",
    "integer"          => ":attribute trebuie sa fie numar intreg.",
    "ip"               => ":attribute trebuie sa fie o adresa IP valida.",
    "max"              => array(
        "numeric" => ":attribute nu poate sa fie mai mare de :max.",
        "file"    => ":attribute nu poate sa fie mai mare de :max kilobytes.",
        "string"  => ":attribute nu trebuie sa fie mai mare de :max caractere.",
    ),
    "mimes"            => ":attribute trebuie sa fie un fisier de tipul :values.",
    "min"              => array(
        "numeric" => ":attribute trebuie sa aiba cel putin :min.",
        "file"    => ":attribute trebuie sa aiba minim :min kilobytes.",
        "string"  => ":attribute trebuie sa aiba cel putin :min caractere.",
    ),
    "not_in"           => ":attribute selectat nu e valid.",
    "numeric"          => ":attribute trebuie sa fie un numar.",
    "regex"            => "Formatul :attribute nu este valid.",
    "required"         => "Campul :attribute este obligatoriu.",
    "required_if"      => ":attribute este obligatoriu atunci cand :other este :value.",
    "required_with"    => ":attribute este obligatoriu atunci cand :values este prezent.",
    "required_without" => ":attribute este obligatoriu atunci cand :values nu este prezent.",
    "same"             => ":attribute si :other trebuie sa fie la fel.",
    "size"             => array(
        "numeric" => ":attribute trebuie sa aiba :size.",
        "file"    => ":attribute trebuie sa aiba :size kilobytes.",
        "string"  => ":attribute trebuie sa aiba :size caractere.",
    ),
    "unique"           => ":attribute este deja folosit.",
    "url"              => "Formatul :attribute nu este valid.",
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
    'alpha_space' => "The :attribute field contains a character that is not allowed.",

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
