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

    'accepted'             => 'A :attribute el kell fogadni.',
    'active_url'           => 'A :attribute nem valós URL.',
    'after'                => 'Az :attribute ezután a dátum után kell, hogy legyen :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'A :attribute csak betűket tartalmazhat.',
    'alpha_dash'           => 'A :attribute csak betűket, számokat és perjelet tartalmazhat.',
    'alpha_num'            => 'A :attribute csak betűket, számokat tartalmazhat.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'A :attribute csak :date elötti dátum lehet.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'A :attribute az érték között kell lennie :min -:max.',
        'file'    => 'A :attribute :min - :max kilobájt között kell lenni.',
        'string'  => 'A :attribute :min - :max karakter között kell lenni.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'Az attribútumnak igaznak, vagy hamisnak kell lennie (true/false).',
    'confirmed'            => 'A :attribute ellenörzés nem egyezik.',
    'date'                 => 'A :attribute nem egy valós dátum.',
    'date_format'          => 'A :attribute nem egyezik a formátummal :format.',
    'different'            => 'A :attribute és :other különböznie kell.',
    'digits'               => 'A :attribute :digits számjegynek kell lenni.',
    'digits_between'       => 'A :attribute :min - :max számjegy között kell lenni.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Az :attribute formátuma érvénytelen.',
    'exists'               => 'A kiválasztott :attribute étvénytelen.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'A :attribute képnek kell lenni.',
    'in'                   => 'A kiválasztott :attribute étvénytelen.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'A :attribute számnak kell lennie.',
    'ip'                   => 'A :attribute érvényes IP címnek kell lenni.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'A :attribute nem lehet nagyobb, mint :max.',
        'file'    => 'A :attribute nem lehet nagyobb, mint :max kilobájt.',
        'string'  => 'A :attribute nem lehet nagyobb, mint :max karakter.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'A :attribute ilyen fájl típusnak kell lennie: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'A :attribute legalább :min kell lenni.',
        'file'    => 'A :attribute legalább :min kilobájt kell lenni.',
        'string'  => 'A :attribute legalább :min karakter kell lenni.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'A kiválasztott :attribute étvénytelen.',
    'numeric'              => 'A :attribute csak szám lehet.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Az :attribute formátuma érvénytelen.',
    'required'             => 'A :attribute mező kötelező.',
    'required_if'          => 'A :attribute mező kötelező ha :other egy :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'A :attribute mező kötelező ha :value jelen van.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'A :attribute mező kötelező ha :value nincs jelen.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'A :attribute és :other egyeznie kell.',
    'size'                 => [
        'numeric' => 'A :attribute kötelező mérete :size.',
        'file'    => 'A :attribute kötelező mérete :size kilobájt.',
        'string'  => 'A :attribute kötelező mérete :size karakter.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'A :attribute már foglalt.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Az :attribute formátuma érvénytelen.',

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
