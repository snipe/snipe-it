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

    "accepted"         => ":attribute tulee hyväksyä.",
    "active_url"       => ":attribute ei ole oikea URL-osoite.",
    "after"            => ":attribute tulee olla päivämäärä päivän :date jälkeen.",
    "alpha"            => ":attribute saa sisältää ainoastaan kirjaimia.",
    "alpha_dash"       => ":attribute voi sisältää vain kirjaimia, numeroita ja viivoja.",
    "alpha_num"        => ":attribute voi sisältää ainoastaan kirjaimia ja numeroita.",
    "before"           => ":attribute tulee olla päivämäärä ennen päivää :date.",
    "between"          => array(
        "numeric" => ":attribute tulee olla välillä :min - :max.",
        "file"    => ":attribute tulee olla välillä :min - :max kilotavua.",
        "string"  => ":attribute tulee olla :min - :max merkkiä.",
    ),
    "confirmed"        => ":attribute vahvistus ei täsmää.",
    "date"             => ":attribute ei ole oikea päivämäärä.",
    "date_format"      => ":attribute ei täsmää muotoiluun :format.",
    "different"        => ":attribute ja :other tulee olla erilaisia.",
    "digits"           => ":attribute tulee olla :digits numeroa pitkä.",
    "digits_between"   => ":attribute tulee olla numero väliltä :min ja :max.",
    "email"            => ":attribute muotoilu on virheellinen.",
    "exists"           => "Valittu :attribute on virheellinen.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute tulee olla kuva.",
    "in"               => "Valittu :attribute on virheellinen.",
    "integer"          => ":attribute tulee olla kokonaisluku.",
    "ip"               => ":attribute tulee olla oikea IP-osoite.",
    "max"              => array(
        "numeric" => ":attribute ei saa olla suurempi kuin :max.",
        "file"    => ":attribute ei saa olla suurempi kuin :max kilotavua.",
        "string"  => ":attribute ei saa olla suurempi kuin :max merkkiä.",
    ),
    "mimes"            => ":attribute tulee olla tiedosto jonka tyyppi on: :values.",
    "min"              => array(
        "numeric" => ":attribute tulee olla vähintään :min.",
        "file"    => ":attribute tulee olla vähintään :min kilotavua.",
        "string"  => ":attribute tulee olla vähintään :min merkkiä.",
    ),
    "not_in"           => "Valittu :attribute on virheellinen.",
    "numeric"          => ":attribute tulee olla numero.",
    "regex"            => ":attribute muotoilu on virheellinen.",
    "required"         => ":attribute on vaadittu.",
    "required_if"      => ":attribute on vaadittu kun :other on :value.",
    "required_with"    => ":attribute on vaadittu kun :values on määritettynä.",
    "required_without" => ":attribute on vaadittu kun :values ei ole määritettynä.",
    "same"             => ":attribute ja :other tulee olla samat.",
    "size"             => array(
        "numeric" => ":attributetulee olla :size.",
        "file"    => ":attribute tulee olla :size kilotavua.",
        "string"  => ":attribute tulee olla :size merkkiä.",
    ),
    "unique"           => ":attribute on jo käytössä.",
    "url"              => ":attribute muotoilu on virheellinen.",
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
