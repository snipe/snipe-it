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
    'after_or_equal'       => 'O :attribute deve ser uma data depois ou igual a :date.',
    'alpha'                => 'O :attribute pode apenas conter letras.',
    'alpha_dash'           => 'O :attribute pode apenas conter letras, números, e traços.',
    'alpha_num'            => 'O :attribute pode apenas conter letras e números.',
    'array'                => 'O :attribute deve estar em ordem.',
    'before'               => 'O :attribute deve ser uma data antes de :date.',
    'before_or_equal'      => 'O atributo: deve ser uma data anterior ou igual a: date.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min - :max.',
        'file'    => 'O :attribute deve estar entre :min - :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min - :max caracteres.',
        'array'   => 'O :attribute deve ter entre :min e :max items.',
    ],
    'boolean'              => 'O :atributo têm que ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do :attribute não corresponde.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao formato :format.',
    'different'            => 'O :attribute e :other devem ser diferentes.',
    'digits'               => 'O :attribute deve ter :digits dígitos.',
    'digits_between'       => 'O :attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O :attribute tem um valor duplicado.',
    'email'                => 'O formato de :attribute é inválido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'O :attribute deve ser um arquivo.',
    'filled'               => 'O :attribute deve ter um valor.',
    'image'                => 'O :attribute deve ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'O :attribute campo não existe em :other.',
    'integer'              => 'O :attribute deve ser um número inteiro.',
    'ip'                   => 'O :attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'O :attribute deve ter um endereço IPv4.',
    'ipv6'                 => 'O :attribute deve ter um IPv6 válido.',
    'json'                 => 'The :attribute deve ser um JSON válida.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior do que :max.',
        'file'    => 'O :attribute não pode ser maior do que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior do que :max caracteres.',
        'array'   => 'O :attribute não pode ter mais que :max items.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O :attribute deve ser um arquivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'O :attribute deve ter pelo menos :min.',
        'file'    => 'O :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'O :attribute deve ter pelo menos :min items.',
    ],
    'not_in'               => 'O :attribute selecionado é inválido.',
    'numeric'              => 'O :attribute deve ser um número.',
    'present'              => 'O campo:attribute deve estar presente.',
    'valid_regex'          => 'Isso não é uma regex válida. ',
    'regex'                => 'O formato de :attribute é inválido.',
    'required'             => 'O campo de :attribute é requerido.',
    'required_if'          => 'O campo de :attribute é requerido quando :other é :value.',
    'required_unless'      => 'O campo:attribute é obrigatório a não ser que: :other estiver em : :values.',
    'required_with'        => 'O campo de :attribute é requerido quando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obrigatorio quando : :values está presente.',
    'required_without'     => 'O campo de :attribute é requerido quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório nenhum dos :values está presente.',
    'same'                 => 'O :attribute e :other devem corresponderem.',
    'size'                 => [
        'numeric' => 'O :attribute deve ser :size.',
        'file'    => 'O :attribute deve ter :size kilobytes.',
        'string'  => 'O :attribute deve ter :size caracteres.',
        'array'   => 'O :attribute deve conter :size items.',
    ],
    'string'               => 'O :attribute deve ser string.',
    'timezone'             => 'O :attribute deve ser um campo válido.',
    'unique'               => 'O :attribute já foi tomado.',
    'uploaded'             => 'O :attribute falhou no upload.',
    'url'                  => 'O formato de :attribute é inválido.',
    "unique_undeleted"     => "O :attribute deve ser único.",

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
        'alpha_space' => "O campo :attribute contém um caractere que não é permitido.",
        "email_array"      => "Um ou mais e-mails sõ invalidos.",
        "hashed_pass"      => "Sua senha atual está incorreta",
        'dumbpwd'          => 'Essa senha é muito comum.',
        "statuslabel_type" => "Você deve selecionar um tipo de etiqueta de status válido",
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
