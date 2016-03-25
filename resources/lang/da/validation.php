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

    "accepted"         => ":attribute skal være accepteret.",
    "active_url"       => ":attribute er ikke en gyldig URL.",
    "after"            => ":attribute skal være en dato efter :date.",
    "alpha"            => ":attribute må kun indeholde bogstaver.",
    "alpha_dash"       => ":attribute må kun indeholde bogstaver, tal eller bindestreger.",
    "alpha_num"        => ":attribute må kun indeholde bogstaver eller tal.",
    "before"           => ":attribute skal være en dato før :date.",
    "between"          => array(
        "numeric" => ":attribute skal være imellem :min - :max.",
        "file"    => ":attribute skal være imellem :min - :max kilobytes.",
        "string"  => ":attribute skal være imellem :min - :max tegn.",
    ),
    "confirmed"        => "The :attribute confirmation does not match.",
    "date"             => ":attribute er ikke en gyldig dato.",
    "date_format"      => ":attribute svarer ikke til formatet :format.",
    "different"        => ":attribute og :other skal være forskellige.",
    "digits"           => ":attribute skal være :digits cifre.",
    "digits_between"   => ":attribute skal være imellem :min og :max cifre.",
    "email"            => ":attribute formatet er ugylidgt.",
    "exists"           => "The selected :attribute is invalid.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute skal være et billede.",
    "in"               => "Det valgte :attribute er ugyldigt.",
    "integer"          => "The :attribute must be an integer.",
    "ip"               => ":attribute skal være en gyldig IP adresse.",
    "max"              => array(
        "numeric" => ":attribute må ikke overstige :max.",
        "file"    => ":attribute må ikke overstige :max. kilobytes.",
        "string"  => ":attribute må ikke overstige :max. tegn.",
    ),
    "mimes"            => ":attribute skal være en fil af typen: :values.",
    "min"              => array(
        "numeric" => ":attribute skal mindst være :min.",
        "file"    => ":attribute skal mindst være :min kilobytes.",
        "string"  => ":attribute skal mindst være :min tegn.",
    ),
    "not_in"           => "The selected :attribute is invalid.",
    "numeric"          => "The :attribute must be a number.",
    "regex"            => ":attribute formatet er ugyldigt.",
    "required"         => ":attribute feltet er krævet.",
    "required_if"      => ":attribute feltet er krævet når :other er :value.",
    "required_with"    => ":attribute er krævet når :values forekommer.",
    "required_without" => ":attribute er krævet når :values ikke forekommer.",
    "same"             => ":attribute og :other skal være ens.",
    "size"             => array(
        "numeric" => ":attribute skal være :size.",
        "file"    => ":attribute skal være :size kilobytes.",
        "string"  => ":attribute skal være :size tegn.",
    ),
    "unique"           => "The :attribute has already been taken.",
    "url"              => ":attribute formatet er ugyldigt.",


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
