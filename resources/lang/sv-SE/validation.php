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

    'accepted'             => 'Attributet måste godkännas.',
    'active_url'           => 'Attributet är inte en giltig URL.',
    'after'                => 'Attributet måste vara ett datum efter: datum.',
    'after_or_equal'       => 'Attributet måste vara ett datum efter eller lika med: datum.',
    'alpha'                => 'Attributet får bara innehålla bokstäver.',
    'alpha_dash'           => 'Attributet får bara innehålla bokstäver, siffror och bindestreck.',
    'alpha_num'            => 'Attributet får bara innehålla bokstäver och siffror.',
    'array'                => 'Attributet måste vara en matris.',
    'before'               => 'Attributet måste vara ett datum före: datum.',
    'before_or_equal'      => 'Attributet måste vara ett datum före eller lika med: datum.',
    'between'              => [
        'numeric' => 'Attributet måste vara mellan: min och: max.',
        'file'    => 'Attributet måste vara mellan: min och: max kilobytes.',
        'string'  => 'Attributet måste vara mellan: min och: max tecken.',
        'array'   => 'Attributet måste ha mellan: min och: max objekt.',
    ],
    'boolean'              => 'Attributfältet måste vara sant eller felaktigt.',
    'confirmed'            => 'Den: Attributbekräftelsen matchar inte.',
    'date'                 => 'Attributet är inte ett giltigt datum.',
    'date_format'          => 'Attributet matchar inte formatet: format.',
    'different'            => 'Attributet: Andet måste vara annorlunda.',
    'digits'               => 'Attributet måste vara: siffror siffror.',
    'digits_between'       => 'Attributet måste vara mellan: min och: max siffror.',
    'dimensions'           => 'Attributet har ogiltiga bilddimensioner.',
    'distinct'             => 'Attributfältet har ett duplikatvärde.',
    'email'                => 'Attributet måste vara en giltig e-postadress.',
    'exists'               => 'Det valda: attributet är ogiltigt.',
    'file'                 => 'Attributet måste vara en fil.',
    'filled'               => 'Attributfältet måste ha ett värde.',
    'image'                => 'Attributet måste vara en bild.',
    'in'                   => 'Det valda: attributet är ogiltigt.',
    'in_array'             => 'Attributfältet existerar inte i: andra.',
    'integer'              => 'Attributet måste vara ett heltal.',
    'ip'                   => 'Attributet måste vara en giltig IP-adress.',
    'ipv4'                 => 'Attributet måste vara en giltig IPv4-adress.',
    'ipv6'                 => 'Attributet måste vara en giltig IPv6-adress.',
    'json'                 => 'Attributet måste vara en giltig JSON-sträng.',
    'max'                  => [
        'numeric' => 'Attributet får inte vara större än: max.',
        'file'    => 'Attributet får inte vara större än: max kilobytes.',
        'string'  => 'Attributet får inte vara större än: Max tecken.',
        'array'   => 'Attributet får inte ha mer än: Max objekt.',
    ],
    'mimes'                => 'Attributet måste vara en fil av typen:: värden.',
    'mimetypes'            => 'Attributet måste vara en fil av typen:: värden.',
    'min'                  => [
        'numeric' => 'Attributet måste vara minst: min.',
        'file'    => 'Attributet måste vara minst: min kilobytes.',
        'string'  => 'Attributet måste vara minst: mina tecken.',
        'array'   => 'Attributet måste ha minst: mina saker.',
    ],
    'not_in'               => 'Det valda: attributet är ogiltigt.',
    'numeric'              => 'Attributet måste vara ett nummer.',
    'present'              => 'Attributfältet måste vara närvarande.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Attributet formatet är ogiltigt.',
    'required'             => 'Fältet: Attribut är obligatoriskt.',
    'required_if'          => 'Attributfältet krävs när: annat är: värde.',
    'required_unless'      => 'Fältet: Attribut är obligatoriskt om inte annat är i: värden.',
    'required_with'        => 'Fältet: Attribut är obligatoriskt när: värdena är närvarande.',
    'required_with_all'    => 'Fältet: Attribut är obligatoriskt när: värdena är närvarande.',
    'required_without'     => 'Fältet: Attribut är obligatoriskt när: värden inte är närvarande.',
    'required_without_all' => 'Attributfältet krävs när ingen av: värdena är närvarande.',
    'same'                 => 'Den: attributet och: andra måste matcha.',
    'size'                 => [
        'numeric' => 'Attributet måste vara: storlek.',
        'file'    => 'Attributet måste vara: storlek kilobytes.',
        'string'  => 'Attributet måste vara: Storlekstecken.',
        'array'   => 'Attributet måste innehålla: storlekar.',
    ],
    'string'               => 'Attributet måste vara en sträng.',
    'timezone'             => 'Attributet måste vara en giltig zon.',
    'unique'               => 'Attributet har redan tagits.',
    'uploaded'             => 'Attributet misslyckades att ladda upp.',
    'url'                  => 'Attributet formatet är ogiltigt.',
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
        'alpha_space' => "Attributfältet innehåller ett tecken som inte är tillåtet.",
        "email_array"      => "En eller flera e-postadresser är ogiltiga.",
        "hashed_pass"      => "Ditt nuvarande lösenord är felaktigt",
        'dumbpwd'          => 'Det lösenordet är för vanligt.',
        "statuslabel_type" => "Du måste välja en giltig status etikett typ",
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
