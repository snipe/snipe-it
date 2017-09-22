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

    'accepted'             => ':attribute a fost acceptat.',
    'active_url'           => ':attribute nu este un URL valid.',
    'after'                => ':attribute trebuie sa fie o data dupa :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute trebuie sa contina numai litere.',
    'alpha_dash'           => ':attribute poate sa contina numai litere, cifre si linia de punctuatie.',
    'alpha_num'            => ':attribute poate sa contina numai litere si cifre.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute trebuie sa contina o data inainte de :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute trebuie sa fie intre :min - :max.',
        'file'    => ':attribute trebuie sa fie intre  :min - :max kilobytes.',
        'string'  => ':attribute trebuie sa aiba intre :min - :max caractere.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Confirmarea la :attribute nu este asemanatoare.',
    'date'                 => ':attribute nu este o data.',
    'date_format'          => ':attribute nu se leaga cu formatul :format.',
    'different'            => ':attribute si :other trebuie sa fie diferite.',
    'digits'               => ':attribute trebuie sa fie de :digits cifre.',
    'digits_between'       => ':attribute trebuie sa fie intre :min si :max cifre.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Formatul :attribute nu este valid.',
    'exists'               => ':attribute selectat nu e valid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute trebuie sa fie o imagine.',
    'in'                   => ':attribute selectat nu este valid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute trebuie sa fie numar intreg.',
    'ip'                   => ':attribute trebuie sa fie o adresa IP valida.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute nu poate sa fie mai mare de :max.',
        'file'    => ':attribute nu poate sa fie mai mare de :max kilobytes.',
        'string'  => ':attribute nu trebuie sa fie mai mare de :max caractere.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute trebuie sa fie un fisier de tipul :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute trebuie sa aiba cel putin :min.',
        'file'    => ':attribute trebuie sa aiba minim :min kilobytes.',
        'string'  => ':attribute trebuie sa aiba cel putin :min caractere.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute selectat nu e valid.',
    'numeric'              => ':attribute trebuie sa fie un numar.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Formatul :attribute nu este valid.',
    'required'             => 'Campul :attribute este obligatoriu.',
    'required_if'          => ':attribute este obligatoriu atunci cand :other este :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute este obligatoriu atunci cand :values este prezent.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute este obligatoriu atunci cand :values nu este prezent.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute si :other trebuie sa fie la fel.',
    'size'                 => [
        'numeric' => ':attribute trebuie sa aiba :size.',
        'file'    => ':attribute trebuie sa aiba :size kilobytes.',
        'string'  => ':attribute trebuie sa aiba :size caractere.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute este deja folosit.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Formatul :attribute nu este valid.',

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
