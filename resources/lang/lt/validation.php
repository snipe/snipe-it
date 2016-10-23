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

    "accepted"         => ":attribute turi būti patvirtintas.",
    "active_url"       => ":attribute nėra tinkamas interentinis puslapis.",
    "after"            => ":attribute privalo būti data po :date.",
    "alpha"            => ":attribute gali būti tik raidės.",
    "alpha_dash"       => ":attribute gali būti tik raidės, skaičiai ir brūkšneliai.",
    "alpha_num"        => ":attribute gali būti tik raidės ir skaičiai.",
    "before"           => ":attribute turi būti data prieš :date.",
    "between"          => array(
        "numeric" => ":attribute privalo būti tarp :min - :max.",
        "file"    => ":attribute privalo būti tarp :min - :max kilobaitų.",
        "string"  => ":attribute privalo būti tarp :min - :max ženklų.",
    ),
    "confirmed"        => ":attribute patvirtinimas nesutampa.",
    "date"             => ":attribute nėra galiojanti data.",
    "date_format"      => ":attribute nesutampa su formatu :format.",
    "different"        => ":attribute ir :other turi būti skirtingi.",
    "digits"           => ":attribute privalo būti :digits skaičiai.",
    "digits_between"   => ":attribute privalo būti tarp :min ir:max skaičių.",
    "email"            => ":attribute formatas neteisingas.",
    "exists"           => "Pasirinktas :attribute neteisingas.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute privalo būti paveikslėlis.",
    "in"               => "Pasirinktas :attribute neteisingas.",
    "integer"          => ":attribute turi būti sveikas skaičius.",
    "ip"               => ":attribute privalo būti tinkamas IP adresas.",
    "max"              => array(
        "numeric" => ":attribute negali būti didesnis nei :max.",
        "file"    => ":attribute negali būti didesnis nei :max kilobaitų.",
        "string"  => ":attribute negali būti didesnis nei :max ženklai.",
    ),
    "mimes"            => ":attribute privalo būti failas, kurio formatas :values.",
    "min"              => array(
        "numeric" => ":attribute privalo būti ne mažesnis nei :min.",
        "file"    => ":attribute turi būti bent :min kilobaitų.",
        "string"  => ":attribute privalo būti bent :min ženklai.",
    ),
    "not_in"           => "Pasirinktas :attribute neteisingas.",
    "numeric"          => ":attribute privalo būti skaičius.",
    "regex"            => ":attribute formatas neteisingas.",
    "required"         => ":attribute laukelis privalomas.",
    "required_if"      => ":attribute laukelis yra privalomas kai :other yra :value.",
    "required_with"    => ":attribute laukelis privalomas kai :values yra nurodytas.",
    "required_without" => ":attribute laukelis privalomas kai :values yra nenurodytas.",
    "same"             => ":attribute ir :other privalo sutapti.",
    "size"             => array(
        "numeric" => ":attribute privalo būti :size.",
        "file"    => ":attribute privalo būti :size kilobaitų.",
        "string"  => ":attribute privalo būti :size ženklų.",
    ),
    "unique"           => ":attribute jau užimtas.",
    "url"              => ":attribute formatas neteisingas.",
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
    'alpha_space' => ":attribute laukelis turi ženklų, kurie neleidžiami.",

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
