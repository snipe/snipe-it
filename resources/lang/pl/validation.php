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
    "confirmed"        => "The :attribute confirmation does not match.",
    "date"             => "The :attribute is not a valid date.",
    "date_format"      => "The :attribute does not match the format :format.",
    "different"        => "The :attribute and :other must be different.",
    "digits"           => "The :attribute must be :digits digits.",
    "digits_between"   => "The :attribute must be between :min and :max digits.",
    "email"            => "Format pola :attribute jest niewłaściwy.",
    "exists"           => "Wybrane :attribute jest niewłaściwe.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute musi być obrazkiem.",
    "in"               => "Wybrane :attribute jest niewłaściwe.",
    "integer"          => ":attribute must musi być liczbą całkowitą.",
    "ip"               => ":attribute musi być poprawnym adresem IP.",
    "max"              => array(
        "numeric" => "The :attribute may not be greater than :max.",
        "file"    => "The :attribute may not be greater than :max kilobytes.",
        "string"  => "The :attribute may not be greater than :max characters.",
    ),
    "mimes"            => "The :attribute must be a file of type: :values.",
    "min"              => array(
        "numeric" => "The :attribute must be at least :min.",
        "file"    => "The :attribute must be at least :min kilobytes.",
        "string"  => "The :attribute must be at least :min characters.",
    ),
    "not_in"           => "The selected :attribute is invalid.",
    "numeric"          => ":attribute musi być liczbą.",
    "regex"            => "Format :attribute jest niewłaściwy.",
    "required"         => ":attribute nie może być puste.",
    "required_if"      => "The :attribute field is required when :other is :value.",
    "required_with"    => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "same"             => "The :attribute and :other must match.",
    "size"             => array(
        "numeric" => "The :attribute must be :size.",
        "file"    => "The :attribute must be :size kilobytes.",
        "string"  => "The :attribute must be :size characters.",
    ),
    "unique"           => "The :attribute has already been taken.",
    "url"              => "The :attribute format is invalid.",


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
