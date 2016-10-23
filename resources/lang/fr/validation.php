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

    "accepted"         => "L'attribut \":attribute\" doit être accepté.",
    "active_url"       => "L'attribut \":attribute\" n'est pas une URL valide.",
    "after"            => "L'attribut \":attribute\" doit être une date après :date.",
    "alpha"            => "L'attribut \":attribute\" ne peut contenir que des lettres.",
    "alpha_dash"       => "L'attribut \":attribute\" ne peut contenir que des lettres, des nombres, et des tirets.",
    "alpha_num"        => "L'attribut \":attribute\" ne peut contenir que des caractères alphanumériques.",
    "before"           => "L'attribut \":attribute\" doit être une date avant :date.",
    "between"          => array(
        "numeric" => "L'attribut \":attribute\" doit être entre :min et :max.",
        "file"    => "L'attribut \":attribute\" doit être entre :min et :max kilo-octets.",
        "string"  => "L'attribut \":attribute\" doit contenir entre :min et :max caractères.",
    ),
    "confirmed"        => "La confirmation et l'attribut \":attribute\" ne concordent pas.",
    "date"             => "L'attribut \":attribute\" n'est pas une date valide.",
    "date_format"      => "L'attribut \":attribute\" ne respecte pas le format \":format\".",
    "different"        => "L'attribut \":attribute\" et l'attribut \":other\" doivent être différents.",
    "digits"           => "L'attribut \":attribute\" doit contenir :digits chiffres.",
    "digits_between"   => "L'attribut \":attribute\" doit contenir entre :min et :max chiffres.",
    "email"            => "Le format de l'attribut \":attribute\" est invalide.",
    "exists"           => "L'attribut \":attribute\" est invalide.",
    "email_array"      => "Une ou plusieurs adresses e-mail sont invalides.",
    "image"            => "L'attribut \":attribute\" doit être une image.",
    "in"               => "Le :attribute selectionné est invalide.",
    "integer"          => "L'attribut \":attribute\" doit être un nombre entier.",
    "ip"               => "L'attribut \":attribute\" doit être une adresse IP valide.",
    "max"              => array(
        "numeric" => "L'attribut \":attribute\" ne peut pas être plus grand que :max.",
        "file"    => "L'attribut \":attribute\" ne doit pas dépasser :max kilo-octets.",
        "string"  => "L'attribut \":attribute\" ne doit pas faire plus de :max caractères.",
    ),
    "mimes"            => "Le fichier :attribute doit être de type :values.",
    "min"              => array(
        "numeric" => "L'attribut \":attribute\" doit être au moins :min.",
        "file"    => "L'attribut \":attribute\" doit faire au moins :min kilo-octets.",
        "string"  => "L'attribut \":attribute\" doit faire au moins :min caractères.",
    ),
    "not_in"           => "L'attribut \":attribute\" est invalide.",
    "numeric"          => "L'attribut \":attribute\" doit être un nombre.",
    "regex"            => "Le format de l'attribut \":attribute\" est invalide.",
    "required"         => "Le champs :attribute est nécessaire.",
    "required_if"      => "Le champ :attribute est nécessaire quand :other vaut :value.",
    "required_with"    => "Le champ :attribute est nécessaire quand :values est présent.",
    "required_without" => "Le champ :attribute est nécessaire quand :values n'est pas présent.",
    "same"             => "L'attribut \":attribute\" et :other doivent correspondre.",
    "size"             => array(
        "numeric" => "L'attribut \":attribute\" doit faire :size.",
        "file"    => "L'attribut \":attribute\" doit faire :size kilo-octets.",
        "string"  => "L'attribut \":attribute\" doit faire :size caractères.",
    ),
    "unique"           => "Cet-te :attribute a déjà été pris-e.",
    "url"              => "Le format de cet-te :attribute est invalide.",
    "statuslabel_type" => "Vous devez sélectionner un type d'étiquette de statut valide",
    "unique_undeleted" => "L'attribut :attribute doit être unique.",


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
    'alpha_space' => "L'attribut \":attribute\" contient un caractère invalide.",

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
