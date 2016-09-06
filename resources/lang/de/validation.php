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

    "accepted"         => ":attribute muss akzeptiert werden.",
    "active_url"       => ":attribute ist keine gültige URL.",
    "after"            => ":attribute muss ein Datum nach dem :date sein.",
    "alpha"            => ":attribute darf nur aus Buchstaben bestehen.",
    "alpha_dash"       => ":attribute darf nur aus Buchstaben, Zahlen und Gedankenstrichen bestehen.",
    "alpha_num"        => ":attribute darf nur aus Buchstaben und Zahlen bestehen.",
    "before"           => ":attribute muss ein Datum vor dem :date sein.",
    "between"          => array(
        "numeric" => ":attribute muss zwischen :min und :max liegen.",
        "file"    => ":attribute darf nur zwischen :min und :max kilobytes groß sein.",
        "string"  => ":attribute muss mindestens :min und maximal :max Zeichen enthalten.",
    ),
    "confirmed"        => ":attribute Bestätigung stimmt nicht überein.",
    "date"             => ":attribute ist kein gültiges Datum.",
    "date_format"      => ":attribute passt nicht zur :format Formatierung.",
    "different"        => ":attribute und :other müssen sich unterscheiden.",
    "digits"           => ":attribute muss :digits Stellen haben.",
    "digits_between"   => ":attribute soll mindestens :min und darf maximal :max Stellen haben.",
    "email"            => "Das Format von :attribute ist ungültig.",
    "exists"           => "Das ausgewählte :attribute ist ungültig.",
    "email_array"      => "Eine oder mehrere Email Adressen sind ungültig.",
    "image"            => ":attribute muss ein Bild sein.",
    "in"               => "Auswahl :attribute ist ungültig.",
    "integer"          => ":attribute muss eine ganze Zahl sein.",
    "ip"               => ":attribute muss eine gültige IP Adresse sein.",
    "max"              => array(
        "numeric" => ":attribute darf nicht größer als :max sein.",
        "file"    => ":attribute darf nicht größer als :max Kilobyte sein.",
        "string"  => ":attribute darf nicht mehr als :max Zeichen sein.",
    ),
    "mimes"            => ":attribute muss eine Datei des Typs :values sein.",
    "min"              => array(
        "numeric" => ":attribute muss kleiner als :min sein.",
        "file"    => ":attribute muss mindestens :min Kilobyte groß sein.",
        "string"  => ":attribute benötigt mindestens :min Zeichen.",
    ),
    "not_in"           => "Auswahl :attribute ist ungültig.",
    "numeric"          => ":attribute muss eine Zahl sein.",
    "regex"            => ":attribute Format ungültig.",
    "required"         => ":attribute Feld muss ausgefüllt sein.",
    "required_if"      => ":attribute wird benötigt wenn :other :value entspricht.",
    "required_with"    => ":attribute wird benötigt wenn :value ausgewählt ist.",
    "required_without" => ":attribute wird benötigt wenn :value nicht ausgewählt ist.",
    "same"             => ":attribute und :other müssen übereinstimmen.",
    "size"             => array(
        "numeric" => ":attribute muss :size groß sein.",
        "file"    => ":attribute muss :size Kilobyte groß sein.",
        "string"  => ":attribute muss :size Zeichen haben.",
    ),
    "unique"           => ":attribute schon benutzt.",
    "url"              => ":attribute Format ist ungültig.",
    "statuslabel_type" => "Gültigen Status Beschriftungstyp auswählen!",
    "unique_undeleted" => ":attribute muss eindeutig sein.",


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
    'alpha_space' => "Das :attribute Feld enthält ein nicht erlaubtes Zeichen.",

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
