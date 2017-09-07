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

    'accepted'             => 'O :attribute tem que ser aceite.',
    'active_url'           => 'O :attribute não é um URL válido.',
    'after'                => 'A :attribute tem que ser superior a :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'O :attribute só pode conter letras.',
    'alpha_dash'           => 'O :attribute só pode conter letras, números e traços.',
    'alpha_num'            => 'O :attribute só pode conter letras e números.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'A :attribute tem que ser anterior a :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min e :max.',
        'file'    => 'O :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min e :max caracteres.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'A confirmação da :attribute não coincide.',
    'date'                 => 'A :attribute não é uma data válida.',
    'date_format'          => ':attribute não corresponde ao formato :format.',
    'different'            => ':attribute e :other têm que ser diferentes.',
    'digits'               => ':attribute de contem :digits dígitos.',
    'digits_between'       => 'O :attribute deve estar entre :min e :max dígitos.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'O formato do :attribute é inválido.',
    'exists'               => 'O :attribute é inválido.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'O :attribute tem que ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'O :attribute tem que ser um inteiro.',
    'ip'                   => 'O :attribute tem que ser um IP válido.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior do que :max.',
        'file'    => 'O :attribute não pode ter mais do que :max kilobytes.',
        'string'  => 'O :attribute não pode tem mais do que :max caracteres.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'O :attribute só pode contem os seguintes formatos: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute deve ter pelos menos :min.',
        'file'    => ':attribute deve ter pelos menos :min kilobytes.',
        'string'  => 'O :attribute deve conter pelos menos :min caracteres.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'O :attribute selecionado é inválido.',
    'numeric'              => ':attribute tem que ser um número.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'O formato do :attribute é inválido.',
    'required'             => ':attribute é obrigatório.',
    'required_if'          => 'O :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'O :attribute é obrigatório quando :values existem.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'O :attribute é obrigatório quando :values não existem.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute e :other devem coincidir.',
    'size'                 => [
        'numeric' => 'O :attribute deve ser maior que :size.',
        'file'    => 'O :attribute deve ter :size kilobytes.',
        'string'  => 'O :attribute deve conter :size caracteres.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Este :attribute já existe.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'O formato do :attribute é inválido.',

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
