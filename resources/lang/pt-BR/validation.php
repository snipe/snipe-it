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
    'after_or_equal'       => 'O atributo: deve ser uma data após ou igual a: data.',
    'alpha'                => 'O :attribute pode apenas conter letras.',
    'alpha_dash'           => 'O :attribute pode apenas conter letras, números, e traços.',
    'alpha_num'            => 'O :attribute pode apenas conter letras e números.',
    'array'                => 'O atributo: deve ser uma matriz.',
    'before'               => 'O :attribute deve ser uma data antes de :date.',
    'before_or_equal'      => 'O atributo: deve ser uma data anterior ou igual a: data.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min - :max.',
        'file'    => 'O :attribute deve estar entre :min - :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min - :max caracteres.',
        'array'   => 'O atributo deve ter entre: min e: itens máximos.',
    ],
    'boolean'              => 'O :atributo têm que ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do :attribute não corresponde.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao formato :format.',
    'different'            => 'O :attribute e :other devem ser diferentes.',
    'digits'               => 'O :attribute deve ter :digits dígitos.',
    'digits_between'       => 'O :attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O atributo: tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo: atributo tem um valor duplicado.',
    'email'                => 'O formato de :attribute é inválido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'O atributo: deve ser um arquivo.',
    'filled'               => 'O campo: atributo deve ter um valor.',
    'image'                => 'O :attribute deve ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'O campo: atributo não existe em: outro.',
    'integer'              => 'O :attribute deve ser um número inteiro.',
    'ip'                   => 'O :attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'O atributo: deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O atributo deve ser um endereço IPv6 válido.',
    'json'                 => 'O atributo: deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior do que :max.',
        'file'    => 'O :attribute não pode ser maior do que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior do que :max caracteres.',
        'array'   => 'O atributo: pode não ter mais do que: itens máximos.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O: atributo deve ser um arquivo de tipo:: valores.',
    'min'                  => [
        'numeric' => 'O :attribute deve ter pelo menos :min.',
        'file'    => 'O :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'O atributo deve ter pelo menos: itens mínimos.',
    ],
    'not_in'               => 'O :attribute selecionado é inválido.',
    'numeric'              => 'O :attribute deve ser um número.',
    'present'              => 'O campo: atributo deve estar presente.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'O formato de :attribute é inválido.',
    'required'             => 'O campo de :attribute é requerido.',
    'required_if'          => 'O campo de :attribute é requerido quando :other é :value.',
    'required_unless'      => 'O campo: atributo é necessário a menos que: outro esteja em: valores.',
    'required_with'        => 'O campo de :attribute é requerido quando :values está presente.',
    'required_with_all'    => 'O campo: atributo é obrigatório quando: os valores estão presentes.',
    'required_without'     => 'O campo de :attribute é requerido quando :values não está presente.',
    'required_without_all' => 'O campo: atributo é obrigatório quando nenhum de: valores estão presentes.',
    'same'                 => 'O :attribute e :other devem corresponderem.',
    'size'                 => [
        'numeric' => 'O :attribute deve ser :size.',
        'file'    => 'O :attribute deve ter :size kilobytes.',
        'string'  => 'O :attribute deve ter :size caracteres.',
        'array'   => 'O atributo: deve conter: itens de tamanho.',
    ],
    'string'               => 'O atributo deve ser uma string.',
    'timezone'             => 'O atributo: deve ser uma zona válida.',
    'unique'               => 'O :attribute já foi tomado.',
    'uploaded'             => 'O atributo: não foi possível carregar.',
    'url'                  => 'O formato de :attribute é inválido.',
    "unique_undeleted"     => "The :attribute must be unique.",

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
        'alpha_space' => "O campo: atributo contém um caractere que não é permitido.",
        "email_array"      => "Um ou mais endereços de e-mail são inválidos.",
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
