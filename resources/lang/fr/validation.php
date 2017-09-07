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

    'accepted'             => 'L\'attribut ":attribute" doit être accepté.',
    'active_url'           => 'L\'attribut ":attribute" n\'est pas une URL valide.',
    'after'                => 'L\'attribut ":attribute" doit être une date après :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'L\'attribut ":attribute" ne peut contenir que des lettres.',
    'alpha_dash'           => 'L\'attribut ":attribute" ne peut contenir que des lettres, des nombres, et des tirets.',
    'alpha_num'            => 'L\'attribut ":attribute" ne peut contenir que des caractères alphanumériques.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'L\'attribut ":attribute" doit être une date avant :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'L\'attribut ":attribute" doit être entre :min et :max.',
        'file'    => 'L\'attribut ":attribute" doit être entre :min et :max kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit contenir entre :min et :max caractères.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'L\'attribut : doit être vrai ou faux.',
    'confirmed'            => 'La confirmation et l\'attribut ":attribute" ne concordent pas.',
    'date'                 => 'L\'attribut ":attribute" n\'est pas une date valide.',
    'date_format'          => 'L\'attribut ":attribute" ne respecte pas le format ":format".',
    'different'            => 'L\'attribut ":attribute" et l\'attribut ":other" doivent être différents.',
    'digits'               => 'L\'attribut ":attribute" doit contenir :digits chiffres.',
    'digits_between'       => 'L\'attribut ":attribute" doit contenir entre :min et :max chiffres.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Le format de l\'attribut ":attribute" est invalide.',
    'exists'               => 'L\'attribut ":attribute" est invalide.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'L\'attribut ":attribute" doit être une image.',
    'in'                   => 'Le :attribute selectionné est invalide.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'L\'attribut ":attribute" doit être un nombre entier.',
    'ip'                   => 'L\'attribut ":attribute" doit être une adresse IP valide.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'L\'attribut ":attribute" ne peut pas être plus grand que :max.',
        'file'    => 'L\'attribut ":attribute" ne doit pas dépasser :max kilo-octets.',
        'string'  => 'L\'attribut ":attribute" ne doit pas faire plus de :max caractères.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'Le fichier :attribute doit être de type :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'L\'attribut ":attribute" doit être au moins :min.',
        'file'    => 'L\'attribut ":attribute" doit faire au moins :min kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit faire au moins :min caractères.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'L\'attribut ":attribute" est invalide.',
    'numeric'              => 'L\'attribut ":attribute" doit être un nombre.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Le format de l\'attribut ":attribute" est invalide.',
    'required'             => 'Le champs :attribute est nécessaire.',
    'required_if'          => 'Le champ :attribute est nécessaire quand :other vaut :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Le champ :attribute est nécessaire quand :values est présent.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Le champ :attribute est nécessaire quand :values n\'est pas présent.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'L\'attribut ":attribute" et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'L\'attribut ":attribute" doit faire :size.',
        'file'    => 'L\'attribut ":attribute" doit faire :size kilo-octets.',
        'string'  => 'L\'attribut ":attribute" doit faire :size caractères.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Cet-te :attribute a déjà été pris-e.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Le format de cet-te :attribute est invalide.',

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
