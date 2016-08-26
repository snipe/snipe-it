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

    "accepted"         => ":attribute moet geaccepteerd worden.",
    "active_url"       => ":attribute is geen geldige URL.",
    "after"            => ":attribute moet een datum zijn later dan :date.",
    "alpha"            => ":attribute mag enkel letters bevatten.",
    "alpha_dash"       => ":attribute mag enkel letters, cijfers of koppeltekens bevatten.",
    "alpha_num"        => ":attribute mag enkel letters en cijfers bevatten.",
    "before"           => ":attribute moet een datum zijn voor :date.",
    "between"          => array(
        "numeric" => ":attribute moet een waarde hebben tussen :min en :max.",
        "file"    => ":attribute moet een waarde hebben tussen :min en :max kilobytes.",
        "string"  => ":attribute moet tussen de :min en :max aantal karakters lang zijn.",
    ),
    "confirmed"        => ":attribute bevestiging komt niet overeen.",
    "date"             => ":attribute is geen geldige datum.",
    "date_format"      => ":attribute komt niet overeen met het volgende formaat :format.",
    "different"        => ":attribute en :other moeten verschillend zijn.",
    "digits"           => ":attribute moet :digits cijfers lang zijn.",
    "digits_between"   => ":attribute moet tussen de :min en :max cijfers bevatten.",
    "email"            => "Het formaat van :attribute is ongeldig.",
    "exists"           => "Het geselecteerde kenmerk :attribute is ongeldig.",
    "email_array"      => "Een of meerdere e-mail adressen kloppen niet.",
    "image"            => ":attribute moet een afbeelding zijn.",
    "in"               => "Het geselecteerde kenmerk :attribute is ongeldig.",
    "integer"          => ":attribute moet van het type integer zijn.",
    "ip"               => ":attribute moet een geldig IP-adres zijn.",
    "max"              => array(
        "numeric" => ":attribute moet groter zijn dan :max.",
        "file"    => ":attribute mag niet groter zijn dan :max kilobytes.",
        "string"  => ":attribute mag niet langer zijn dan :max karakters.",
    ),
    "mimes"            => ":attribute moet een bestand zijn van het type: :values.",
    "min"              => array(
        "numeric" => ":attribute moet minimum :min zijn.",
        "file"    => ":attribute moet minstens :min kilobytes groot zijn.",
        "string"  => ":attribute moet tenminste :min karakters bevatten.",
    ),
    "not_in"           => "Het geselecteerde kenmerk :attribute is ongeldig.",
    "numeric"          => ":attribute moet een getal zijn.",
    "regex"            => "Het formaat van :attribute is ongeldig.",
    "required"         => "Het veld :attribute is verplicht.",
    "required_if"      => "het veld :attribute is verplicht als :other gelijk is aan :value.",
    "required_with"    => "Het veld :attribute is verplicht als :values ingesteld staan.",
    "required_without" => "Het veld :attribute is verplicht als :values niet ingesteld staan.",
    "same"             => ":attribute en :other moeten gelijk zijn.",
    "size"             => array(
        "numeric" => ":attribute moet :size zijn.",
        "file"    => ":attribute moet :size kilobytes groot zijn.",
        "string"  => ":attribute moet :size karakters zijn.",
    ),
    "unique"           => "Het veld :attribute is reeds in gebruik.",
    "url"              => "Het formaat van :attribute is ongeldig.",
    "statuslabel_type" => "Je moet een geldig status label type selecteren",
    "unique_undeleted" => "Het :attribute moet uniek zijn.",


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
    'alpha_space' => "Het :attribuut veld bevat een karakter dat is niet toegestaan.",

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
