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

    "accepted"         => "Attributtet :attribute må velges.",
    "active_url"       => "Attributtet :attribute er ikke en gyldig URL.",
    "after"            => "Attributtet :attribute må være en dato etter :date.",
    "alpha"            => "Attributtet :attribute kan kun inneholde bokstaver.",
    "alpha_dash"       => "Attributtet :attribute kan kun inneholde bokstaver, nummer eller bindestrek.",
    "alpha_num"        => "Attributtet :attribute kan kun inneholde bokstaver og numre.",
    "before"           => "Attributtet :attribute må være en dato før :date.",
    "between"          => array(
        "numeric" => "Attributtet :attribute må være mellom :min og :max.",
        "file"    => "Attributtet :attribute må være mellom :min og :max kilobytes.",
        "string"  => "Attributtet :attribute må være mellom :min og :max tegn.",
    ),
    "confirmed"        => "Bekreftelse på attributtet :attribute stemmer ikke.",
    "date"             => "Attributtet :attribute er ikke en gyldig dato.",
    "date_format"      => "Attributtet :attribute passer ikke formatet :format.",
    "different"        => "Attributtet :attribute og :other er forskjellige.",
    "digits"           => "Attributtet :attribute må være :digits sifre.",
    "digits_between"   => "Attributtet :attribute må være mellom :min og :max sifre.",
    "email"            => "Attributtet :attribute er ugyldig.",
    "exists"           => "Valgt attributt :attribute er ugyldig.",
    "email_array"      => "En eller flere e-postadresser er ugyldig.",
    "image"            => "Attributtet :attribute må være et bilde.",
    "in"               => "Det valgte attributtet :attribute er ugyldig.",
    "integer"          => "Attributtet :attribute må være et heltall.",
    "ip"               => "Attributtet :attribute må være en gyldig IP-adresse.",
    "max"              => array(
        "numeric" => "Attributtet :attribute må ikke være større enn :max.",
        "file"    => "Attributtet :attribute kan ikke være større enn :max kilobytes.",
        "string"  => "Attributtet :attribute kan ikke være større enn :max tegn.",
    ),
    "mimes"            => "Attributtet :attribute må være en fil av typen: :values.",
    "min"              => array(
        "numeric" => "Attributtet :attribute må være minst :min.",
        "file"    => "Attributtet :attribute må være minst :min kilobytes.",
        "string"  => "Attributtet :attribute må være minst :min tegn.",
    ),
    "not_in"           => "Attributtet :attribute er ugyldig.",
    "numeric"          => "Attributtet :attribute må være et nummer.",
    "regex"            => "Attributt-formatet til :attribute er ugyldig.",
    "required"         => "Attributt-feltet :attribute er påkrevd.",
    "required_if"      => "Attributt-feltet :attribute er påkrevd når :oher er :value.",
    "required_with"    => "Attributt-feltet :attribute er påkrevd når :values er tilstede.",
    "required_without" => "Attributt-feltet :attribute er påkrevd når :values ikke er tilstede.",
    "same"             => "Attributtet :attribute og :other må være like.",
    "size"             => array(
        "numeric" => "Attributtet :attribute må være :size.",
        "file"    => "Attributtet :attribute må være :size kilobytes.",
        "string"  => "Attributtet :attribute må være :size tegn.",
    ),
    "unique"           => "Attributtet :attribute er allerede tatt.",
    "url"              => "Attributt-formatet :attribute er ugyldig.",
    "statuslabel_type" => "Du må velge en gyldig statusetikett-type",
    "unique_undeleted" => ":attribute må være unik.",


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
    'alpha_space' => "Feltet :attribute innholder ugyldige tegn.",

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
