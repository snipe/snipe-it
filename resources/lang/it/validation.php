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

    'accepted'             => 'il  :attribute è stato accettato.',
    'active_url'           => ':attribute non è un URL valido.',
    'after'                => ':attribute deve essere una data oltre il  :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute può contenere solo lettere.',
    'alpha_dash'           => ':attribute può contenere solo lettere numeri e trattini.',
    'alpha_num'            => ':attribute può contenere solo lettere e numeri.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute deve essere una data dopo :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute deve essere tra  :min - :max.',
        'file'    => 'il :attribute deve essere tra  :min - :max kilobytes.',
        'string'  => 'il :attribute deve essere tra :min - :max caratteri.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'il :attribute non corrisponde.',
    'date'                 => 'la :attribute non è valida.',
    'date_format'          => 'il :attribute non corrisponde al :format.',
    'different'            => 'il :attribute e :other devono essere differenti.',
    'digits'               => 'il :attribute deve essere :digits digits.',
    'digits_between'       => 'il  :attribute deve essere tra :min e :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'il formato del :attribute è invalido.',
    'exists'               => ':attribute selezzionato è invalido.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'il :attribute deve essere un immagine.',
    'in'                   => 'Il selezionato :attribute è invalido.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'L\' :attribute deve essere un numero intero.',
    'ip'                   => 'L\' :attribute deve essere un indirizzo IP valido.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'L\' :attribute non può essere superiore di :max.',
        'file'    => 'L\' :attribute non può essere maggiore di :max kilobytes.',
        'string'  => 'L\' :attribute non può essere maggiore di :max caratteri.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'L\' :attribute deve essere un file di type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'L\' :attribute deve essere almeno :min.',
        'file'    => 'L\' :attribute deve essere almeno :min kilobytes.',
        'string'  => 'L\' :attribute deve essere almeno :min caratteri.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'L\' :attribute selezionato è invalido.',
    'numeric'              => 'L\' :attribute deve essere un numero.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Il formato dell\' :attribute è invalido.',
    'required'             => 'Il campo :attribute è obblogatorio.',
    'required_if'          => 'L\' :attribute è richiesto quando :other è :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'L\' :attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => 'L\' :attribute deve essere :size.',
        'file'    => 'L\' :attribute deve essere :size kilobytes.',
        'string'  => 'L\' :attribute deve essere :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'L\' :attribute è già stato preso.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Il formato dell\' :attribute è invalido.',

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
