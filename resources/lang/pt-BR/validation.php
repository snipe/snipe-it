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

    'accepted'             => 'O :attribute dever ser aceito.',
    'active_url'           => 'O :attribute não é uma URL válida.',
    'after'                => 'O :attribute deve ser uma data após :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'O :attribute pode apenas conter letras.',
    'alpha_dash'           => 'O :attribute pode apenas conter letras, números, e traços.',
    'alpha_num'            => 'O :attribute pode apenas conter letras e números.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'O :attribute deve ser uma data antes de :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min - :max.',
        'file'    => 'O :attribute deve estar entre :min - :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min - :max caracteres.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'O :atributo têm que ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do :attribute não corresponde.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao formato :format.',
    'different'            => 'O :attribute e :other devem ser diferentes.',
    'digits'               => 'O :attribute deve ter :digits dígitos.',
    'digits_between'       => 'O :attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'O formato de :attribute é inválido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'O :attribute deve ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'O :attribute deve ser um número inteiro.',
    'ip'                   => 'O :attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior do que :max.',
        'file'    => 'O :attribute não pode ser maior do que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior do que :max caracteres.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'O :attribute deve ter pelo menos :min.',
        'file'    => 'O :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'O :attribute selecionado é inválido.',
    'numeric'              => 'O :attribute deve ser um número.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'O formato de :attribute é inválido.',
    'required'             => 'O campo de :attribute é requerido.',
    'required_if'          => 'O campo de :attribute é requerido quando :other é :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'O campo de :attribute é requerido quando :values está presente.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'O campo de :attribute é requerido quando :values não está presente.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'O :attribute e :other devem corresponderem.',
    'size'                 => [
        'numeric' => 'O :attribute deve ser :size.',
        'file'    => 'O :attribute deve ter :size kilobytes.',
        'string'  => 'O :attribute deve ter :size caracteres.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'O :attribute já foi tomado.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'O formato de :attribute é inválido.',

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
