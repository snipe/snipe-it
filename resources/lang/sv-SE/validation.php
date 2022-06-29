<?php

return [

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

    'accepted'             => ':attribute måste accepteras.',
    'active_url'           => ':attribute är inte en giltig URL.',
    'after'                => ':attribute måste vara ett datum efter :date.',
    'after_or_equal'       => ':attribute måste vara ett datum efter eller lika med :date.',
    'alpha'                => ':attribute får bara innehålla bokstäver.',
    'alpha_dash'           => ':attribute får bara innehålla bokstäver, siffror och bindestreck.',
    'alpha_num'            => ':attribute får bara innehålla bokstäver och siffror.',
    'array'                => ':attribute måste vara en tabell.',
    'before'               => ':attribute måste vara ett datum före :date.',
    'before_or_equal'      => ':attribute måste vara ett datum före eller lika med :date.',
    'between'              => [
        'numeric' => ':attribute måste vara mellan :min och :max.',
        'file'    => ':attribute måste vara mellan :min och :max kilobytes.',
        'string'  => ':attribute måste vara mellan :min och :max tecken.',
        'array'   => ':attribute måste ha mellan :min och :max objekt.',
    ],
    'boolean'              => ':attribute måste vara sant eller falskt.',
    'confirmed'            => ':attribute matchar inte.',
    'date'                 => ':attribute är inte ett giltigt datum.',
    'date_format'          => ':attribute matchar inte formatet :format.',
    'different'            => ':attribute och :other kan inte vara samma.',
    'digits'               => ':attributet måste vara :digits siffror.',
    'digits_between'       => ':attribute måste vara mellan :min och :max siffror.',
    'dimensions'           => ':attribute har ogiltigt bildmått.',
    'distinct'             => ':attribute fältet har samma värde.',
    'email'                => ':attribute måste vara en giltig e-postadress.',
    'exists'               => 'Det valda :attribute är ogiltigt.',
    'file'                 => ':attribute måste vara en fil.',
    'filled'               => ':attribute fältet måste ha ett värde.',
    'image'                => ':attribute måste vara en bild.',
    'in'                   => 'Det valda :attribute är ogiltigt.',
    'in_array'             => ':attribute fältet existerar inte i :other.',
    'integer'              => ':attribute måste vara ett heltal.',
    'ip'                   => ':attribute måste vara en giltig IP-adress.',
    'ipv4'                 => ':attribute måste vara en giltig IPv4-adress.',
    'ipv6'                 => ':attribute måste vara en giltig IPv6-adress.',
    'json'                 => ':attribute måste vara en giltig JSON-sträng.',
    'max'                  => [
        'numeric' => ':attribute får inte vara större än :max.',
        'file'    => ':attribute får inte vara större än :max kilobytes.',
        'string'  => ':attribute får inte vara större än :max tecken.',
        'array'   => ':attribute får inte ha mer än :max objekt.',
    ],
    'mimes'                => ':attribute måste vara en fil av typen: :values.',
    'mimetypes'            => ':attribute måste vara en fil av typen: :values.',
    'min'                  => [
        'numeric' => ':attribute måste vara minst :min.',
        'file'    => ':attribute måste vara minst :min kilobytes.',
        'string'  => ':attribute måste vara minst :min tecken.',
        'array'   => ':attribute måste innehålla minst :min saker.',
    ],
    'starts_with'          => ':attribute måste börja med något av följande: :values.',
    'not_in'               => 'Det valda :attribute är ogiltigt.',
    'numeric'              => ':attribute måste vara ett nummer.',
    'present'              => ':attribute fältet måste finnas.',
    'valid_regex'          => 'Ogiltig regex. ',
    'regex'                => ':attribute formatet är ogiltigt.',
    'required'             => 'Fältet: :attribute är obligatoriskt.',
    'required_if'          => 'Fältet :attribute krävs när :other är :value.',
    'required_unless'      => 'Fältet :attribute krävs om inte :other anges i :values.',
    'required_with'        => 'Fältet :attribute krävs när :values angivits.',
    'required_with_all'    => 'Fältet :attribute krävs när :values angivits.',
    'required_without'     => 'Fältet :attribute krävs när :values saknas.',
    'required_without_all' => 'Fältet :attribute krävs när inga :values har angetts.',
    'same'                 => ':attribute och :other måste vara samma.',
    'size'                 => [
        'numeric' => ':attribute måste vara :size.',
        'file'    => ':attribute måste vara :size kilobytes.',
        'string'  => ':attribute måste vara :size tecken.',
        'array'   => ':attribute måste innehålla :size artiklar.',
    ],
    'string'               => ':attribute måste vara en sträng.',
    'timezone'             => ':attribute måste vara en giltig zon.',
    'unique'               => ':attribute är upptaget.',
    'uploaded'             => 'Uppladdningen av :attribute misslyckades.',
    'url'                  => ':attribute Formatet är ogiltigt.',
    'unique_undeleted'     => ':attribute måste vara unikt.',
    'non_circular'         => ':attribute får inte skapa en cirkulär referens.',
    'gte'                  => [
        'numeric'          => 'Value cannot be negative'
    ],


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
        'alpha_space' => 'Fältet :attribute innehåller ett tecken som inte är tillåtet.',
        'email_array'      => 'En eller flera e-postadresser är ogiltiga.',
        'hashed_pass'      => 'Ditt nuvarande lösenord är felaktigt',
        'dumbpwd'          => 'Det angivna lösenordet är för vanligt.',
        'statuslabel_type' => 'Du måste ange en giltig typ av statusetikett',
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

];
