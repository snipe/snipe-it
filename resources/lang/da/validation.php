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
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute må kun indeholde bogstaver.',
    'alpha_dash'           => ':attribute må kun indeholde bogstaver, tal eller bindestreger.',
    'alpha_num'            => ':attribute må kun indeholde bogstaver eller tal.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute skal være en dato før :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute skal være imellem :min - :max.',
        'file'    => ':attribute skal være imellem :min - :max kilobytes.',
        'string'  => ':attribute skal være imellem :min - :max tegn.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => ':attribute er ikke en gyldig dato.',
    'date_format'          => ':attribute svarer ikke til formatet :format.',
    'different'            => ':attribute og :other skal være forskellige.',
    'digits'               => ':attribute skal være :digits cifre.',
    'digits_between'       => ':attribute skal være imellem :min og :max cifre.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute formatet er ugylidgt.',
    'exists'               => 'Den valgte :attribute er ugyldig.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute skal være et billede.',
    'in'                   => 'Det valgte :attribute er ugyldigt.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute skal være et heltal.',
    'ip'                   => ':attribute skal være en gyldig IP adresse.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute må ikke overstige :max.',
        'file'    => ':attribute må ikke overstige :max. kilobytes.',
        'string'  => ':attribute må ikke overstige :max. tegn.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute skal være en fil af typen: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute skal mindst være :min.',
        'file'    => ':attribute skal mindst være :min kilobytes.',
        'string'  => ':attribute skal mindst være :min tegn.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Den valgte :attribute er ugyldig.',
    'numeric'              => ':attribute skal være et tal.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute formatet er ugyldigt.',
    'required'             => ':attribute feltet er krævet.',
    'required_if'          => ':attribute feltet er krævet når :other er :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute er krævet når :values forekommer.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute er krævet når :values ikke forekommer.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute og :other skal være ens.',
    'size'                 => [
        'numeric' => ':attribute skal være :size.',
        'file'    => ':attribute skal være :size kilobytes.',
        'string'  => ':attribute skal være :size tegn.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute er allerede taget.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute formatet er ugyldigt.',

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
