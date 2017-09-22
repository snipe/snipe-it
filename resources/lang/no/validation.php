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

    'accepted'             => 'Attributtet :attribute må velges.',
    'active_url'           => 'Attributtet :attribute er ikke en gyldig URL.',
    'after'                => 'Attributtet :attribute må være en dato etter :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'Attributtet :attribute kan kun inneholde bokstaver.',
    'alpha_dash'           => 'Attributtet :attribute kan kun inneholde bokstaver, nummer eller bindestrek.',
    'alpha_num'            => 'Attributtet :attribute kan kun inneholde bokstaver og numre.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'Attributtet :attribute må være en dato før :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'Attributtet :attribute må være mellom :min og :max.',
        'file'    => 'Attributtet :attribute må være mellom :min og :max kilobytes.',
        'string'  => 'Attributtet :attribute må være mellom :min og :max tegn.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Bekreftelse på attributtet :attribute stemmer ikke.',
    'date'                 => 'Attributtet :attribute er ikke en gyldig dato.',
    'date_format'          => 'Attributtet :attribute passer ikke formatet :format.',
    'different'            => 'Attributtet :attribute og :other er forskjellige.',
    'digits'               => 'Attributtet :attribute må være :digits sifre.',
    'digits_between'       => 'Attributtet :attribute må være mellom :min og :max sifre.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Attributtet :attribute er ugyldig.',
    'exists'               => 'Valgt attributt :attribute er ugyldig.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'Attributtet :attribute må være et bilde.',
    'in'                   => 'Det valgte attributtet :attribute er ugyldig.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'Attributtet :attribute må være et heltall.',
    'ip'                   => 'Attributtet :attribute må være en gyldig IP-adresse.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Attributtet :attribute må ikke være større enn :max.',
        'file'    => 'Attributtet :attribute kan ikke være større enn :max kilobytes.',
        'string'  => 'Attributtet :attribute kan ikke være større enn :max tegn.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'Attributtet :attribute må være en fil av typen: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'Attributtet :attribute må være minst :min.',
        'file'    => 'Attributtet :attribute må være minst :min kilobytes.',
        'string'  => 'Attributtet :attribute må være minst :min tegn.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Attributtet :attribute er ugyldig.',
    'numeric'              => 'Attributtet :attribute må være et nummer.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Attributt-formatet til :attribute er ugyldig.',
    'required'             => 'Attributt-feltet :attribute er påkrevd.',
    'required_if'          => 'Attributt-feltet :attribute er påkrevd når :oher er :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Attributt-feltet :attribute er påkrevd når :values er tilstede.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Attributt-feltet :attribute er påkrevd når :values ikke er tilstede.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'Attributtet :attribute og :other må være like.',
    'size'                 => [
        'numeric' => 'Attributtet :attribute må være :size.',
        'file'    => 'Attributtet :attribute må være :size kilobytes.',
        'string'  => 'Attributtet :attribute må være :size tegn.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Attributtet :attribute er allerede tatt.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Attributt-formatet :attribute er ugyldig.',

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
