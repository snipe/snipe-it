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

    'accepted'             => ':attribute skal være accepteret.',
    'active_url'           => ':attribute er ikke en gyldig URL.',
    'after'                => ':attribute skal være en dato efter :date.',
    'after_or_equal'       => 'Attributten skal være en dato efter eller lig med: dato.',
    'alpha'                => ':attribute må kun indeholde bogstaver.',
    'alpha_dash'           => ':attribute må kun indeholde bogstaver, tal eller bindestreger.',
    'alpha_num'            => ':attribute må kun indeholde bogstaver eller tal.',
    'array'                => 'Attributten skal være en matrix.',
    'before'               => ':attribute skal være en dato før :date.',
    'before_or_equal'      => 'Attributten skal være en dato før eller lig med: dato.',
    'between'              => [
        'numeric' => ':attribute skal være imellem :min - :max.',
        'file'    => ':attribute skal være imellem :min - :max kilobytes.',
        'string'  => ':attribute skal være imellem :min - :max tegn.',
        'array'   => 'Attributten skal have mellem: min og: maks. Emner.',
    ],
    'boolean'              => 'Attributfeltet skal være sandt eller falsk.',
    'confirmed'            => 'Attributbevisningen stemmer ikke overens.',
    'date'                 => ':attribute er ikke en gyldig dato.',
    'date_format'          => ':attribute svarer ikke til formatet :format.',
    'different'            => ':attribute og :other skal være forskellige.',
    'digits'               => ':attribute skal være :digits cifre.',
    'digits_between'       => ':attribute skal være imellem :min og :max cifre.',
    'dimensions'           => 'Attributten har ugyldige billeddimensioner.',
    'distinct'             => 'Attributfeltet har en duplikatværdi.',
    'email'                => ':attribute formatet er ugylidgt.',
    'exists'               => 'Den valgte :attribute er ugyldig.',
    'file'                 => 'Attributten skal være en fil.',
    'filled'               => 'Attributfeltet skal have en værdi.',
    'image'                => ':attribute skal være et billede.',
    'in'                   => 'Det valgte :attribute er ugyldigt.',
    'in_array'             => 'Attributfeltet findes ikke i: andet.',
    'integer'              => ':attribute skal være et heltal.',
    'ip'                   => ':attribute skal være en gyldig IP adresse.',
    'ipv4'                 => 'Attributten skal være en gyldig IPv4-adresse.',
    'ipv6'                 => 'Attributten skal være en gyldig IPv6-adresse.',
    'json'                 => 'Attributten skal være en gyldig JSON-streng.',
    'max'                  => [
        'numeric' => ':attribute må ikke overstige :max.',
        'file'    => ':attribute må ikke overstige :max. kilobytes.',
        'string'  => ':attribute må ikke overstige :max. tegn.',
        'array'   => 'Attributten må ikke have mere end: maks. Emner.',
    ],
    'mimes'                => ':attribute skal være en fil af typen: :values.',
    'mimetypes'            => 'Attributten skal være en fil af typen:: værdier.',
    'min'                  => [
        'numeric' => ':attribute skal mindst være :min.',
        'file'    => ':attribute skal mindst være :min kilobytes.',
        'string'  => ':attribute skal mindst være :min tegn.',
        'array'   => 'Attributten skal have mindst: min elementer.',
    ],
    'not_in'               => 'Den valgte :attribute er ugyldig.',
    'numeric'              => ':attribute skal være et tal.',
    'present'              => 'Attributfeltet skal være til stede.',
    'regex'                => ':attribute formatet er ugyldigt.',
    'required'             => ':attribute feltet er krævet.',
    'required_if'          => ':attribute feltet er krævet når :other er :value.',
    'required_unless'      => 'Attributfeltet er påkrævet, medmindre: andet er i: værdier.',
    'required_with'        => ':attribute er krævet når :values forekommer.',
    'required_with_all'    => 'Attributfeltet er påkrævet, når: værdier er til stede.',
    'required_without'     => ':attribute er krævet når :values ikke forekommer.',
    'required_without_all' => 'Attributfeltet er påkrævet, når ingen af: værdier er til stede.',
    'same'                 => ':attribute og :other skal være ens.',
    'size'                 => [
        'numeric' => ':attribute skal være :size.',
        'file'    => ':attribute skal være :size kilobytes.',
        'string'  => ':attribute skal være :size tegn.',
        'array'   => 'Attributten skal indeholde: størrelseselementer.',
    ],
    'string'               => 'Attributten skal være en streng.',
    'timezone'             => 'Attributten skal være en gyldig zone.',
    'unique'               => ':attribute er allerede taget.',
    'uploaded'             => 'Attributtet kunne ikke uploades.',
    'url'                  => ':attribute formatet er ugyldigt.',
    "unique_undeleted"     => "The :attribute must be unique.",

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

    'custom' => [
        'alpha_space' => "Attributfeltet indeholder et tegn, der ikke er tilladt.",
        "email_array"      => "En eller flere e-mailadresser er ugyldige.",
        "hashed_pass"      => "Din nuværende adgangskode er forkert",
        'dumbpwd'          => 'Denne adgangskode er for almindelig.',
        "statuslabel_type" => "Du skal vælge en gyldig statusetiketype",
    ],

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

    'attributes' => [],

);
