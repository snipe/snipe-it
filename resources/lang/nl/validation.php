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

    'accepted'             => ':attribute moet geaccepteerd worden.',
    'active_url'           => ':attribute is geen geldige URL.',
    'after'                => ':attribute moet een datum zijn later dan :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute mag enkel letters bevatten.',
    'alpha_dash'           => ':attribute mag enkel letters, cijfers of koppeltekens bevatten.',
    'alpha_num'            => ':attribute mag enkel letters en cijfers bevatten.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute moet een datum zijn voor :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute moet een waarde hebben tussen :min en :max.',
        'file'    => ':attribute moet een waarde hebben tussen :min en :max kilobytes.',
        'string'  => ':attribute moet tussen de :min en :max aantal karakters lang zijn.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute moet waar of onwaar zijn.',
    'confirmed'            => ':attribute bevestiging komt niet overeen.',
    'date'                 => ':attribute is geen geldige datum.',
    'date_format'          => ':attribute komt niet overeen met het volgende formaat :format.',
    'different'            => ':attribute en :other moeten verschillend zijn.',
    'digits'               => ':attribute moet :digits cijfers lang zijn.',
    'digits_between'       => ':attribute moet tussen de :min en :max cijfers bevatten.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Het formaat van :attribute is ongeldig.',
    'exists'               => 'Het geselecteerde kenmerk :attribute is ongeldig.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute moet een afbeelding zijn.',
    'in'                   => 'Het geselecteerde kenmerk :attribute is ongeldig.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute moet van het type integer zijn.',
    'ip'                   => ':attribute moet een geldig IP-adres zijn.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute moet groter zijn dan :max.',
        'file'    => ':attribute mag niet groter zijn dan :max kilobytes.',
        'string'  => ':attribute mag niet langer zijn dan :max karakters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute moet een bestand zijn van het type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute moet minimum :min zijn.',
        'file'    => ':attribute moet minstens :min kilobytes groot zijn.',
        'string'  => ':attribute moet tenminste :min karakters bevatten.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Het geselecteerde kenmerk :attribute is ongeldig.',
    'numeric'              => ':attribute moet een getal zijn.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Het formaat van :attribute is ongeldig.',
    'required'             => 'Het veld :attribute is verplicht.',
    'required_if'          => 'het veld :attribute is verplicht als :other gelijk is aan :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Het veld :attribute is verplicht als :values ingesteld staan.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Het veld :attribute is verplicht als :values niet ingesteld staan.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute en :other moeten gelijk zijn.',
    'size'                 => [
        'numeric' => ':attribute moet :size zijn.',
        'file'    => ':attribute moet :size kilobytes groot zijn.',
        'string'  => ':attribute moet :size karakters zijn.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Het veld :attribute is reeds in gebruik.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Het formaat van :attribute is ongeldig.',

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
        'alpha_space' => "The :attribute field contains a character that is not allowed.",
        "email_array"      => "One or more email addresses is invalid.",
        "hashed_pass"      => "Your current password is incorrect",
        'dumbpwd'          => 'That password is too common.',
        "statuslabel_type" => "You must select a valid status label type",
        "unique_undeleted" => "The :attribute must be unique.",
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
