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

    "accepted"         => ":attribute musi zostać zaakceptowany.",
    "active_url"       => ":attribute nie jest poprawnym adresem URL.",
    "after"            => ":attribute musi być późniejszą datą w stosunku do :date.",
    "alpha"            => ":attribute może zawierać tylko litery.",
    "alpha_dash"       => ":attribute może zawierać tylko litery, cyfry i myślniki.",
    "alpha_num"        => ":attribute może zawierać tylko litery i cyfry.",
    "before"           => ":attribute musi być późniejszą datą w stosunku do :date.",
    "between"          => array(
        "numeric" => ":attribute musi być pomiędzy :min - :max.",
        "file"    => ":attribute musi być pomiędzy :min - :max kilobajtów.",
        "string"  => ":attribute musi być pomiędzy :min - :max znaków.",
    ),
    "confirmed"        => "Potwierdzenie :attribute nie pasuje.",
    "date"             => ":attribute nie jest prawidłową datą.",
    "date_format"      => "Format :attribute nie pasuje do :format.",
    "different"        => ":attribute musi różnić się od :other.",
    "digits"           => ":attribute musi posiadać cyfry :digits.",
    "digits_between"   => ":attribute musi być pomiędzy cyframi :min i :max.",
    "email"            => "Format pola :attribute jest niewłaściwy.",
    "exists"           => "Wybrane :attribute jest niewłaściwe.",
    "email_array"      => "Jeden lub więcej wprowadzonych adresów jest nieprawidłowy.",
    "image"            => ":attribute musi być obrazkiem.",
    "in"               => "Wybrane :attribute jest niewłaściwe.",
    "integer"          => ":attribute must musi być liczbą całkowitą.",
    "ip"               => ":attribute musi być poprawnym adresem IP.",
    "max"              => array(
        "numeric" => ":attribute nie może być większy niż :max.",
        "file"    => ":attribute nie może być więszky niż :max kilobajtów.",
        "string"  => ":attribute nie może posiadać więcej znaków niż :max.",
    ),
    "mimes"            => ":attribute musi być plikiem z rozszerzeniami :values.",
    "min"              => array(
        "numeric" => ":attribute musi być przynajmniej :min.",
        "file"    => ":attribute musi być przynajmniej wielkości :min kilobajtów.",
        "string"  => ":attribute musi być posiadać minimum :min znaki.",
    ),
    "not_in"           => "Wybrany :attribute jest nieprawidłowy.",
    "numeric"          => ":attribute musi być liczbą.",
    "regex"            => "Format :attribute jest niewłaściwy.",
    "required"         => ":attribute nie może być puste.",
    "required_if"      => "Pole :attribute jest wymagane gdy :other jest :value.",
    "required_with"    => "Pole :attribute jest wymagane gdy :values jest podana.",
    "required_without" => "Pole :attribute jest wymagane gdy :values nie jest podana.",
    "same"             => ":attribute i :other muszą pasować.",
    "size"             => array(
        "numeric" => ":attribute musi być wielkości :size.",
        "file"    => ":attribute musi być :size kilobajtów.",
        "string"  => ":attribute musi być :size znakowy.",
    ),
    "unique"           => ":attribute został już wzięty.",
    "url"              => "Format pola :attribute jest niewłaściwy.",
    "statuslabel_type" => "Musisz wybrać poprawny status typu etykiety",
    "unique_undeleted" => ":attribute musi być unikalny.",


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
    'alpha_space' => "Pole :attribute posiada znak, który jest niedozwolony.",

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
