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

    "accepted"         => "O :attribute dever ser aceito.",
    "active_url"       => "O :attribute não é uma URL válida.",
    "after"            => "O :attribute deve ser uma data após :date.",
    "alpha"            => "O :attribute pode apenas conter letras.",
    "alpha_dash"       => "O :attribute pode apenas conter letras, números, e traços.",
    "alpha_num"        => "O :attribute pode apenas conter letras e números.",
    "before"           => "O :attribute deve ser uma data antes de :date.",
    "between"          => array(
        "numeric" => "O :attribute deve estar entre :min - :max.",
        "file"    => "O :attribute deve estar entre :min - :max kilobytes.",
        "string"  => "O :attribute deve estar entre :min - :max caracteres.",
    ),
    "confirmed"        => "A confirmação do :attribute não corresponde.",
    "date"             => "O :attribute não é uma data válida.",
    "date_format"      => "O :attribute não corresponde ao formato :format.",
    "different"        => "O :attribute e :other devem ser diferentes.",
    "digits"           => "O :attribute deve ter :digits dígitos.",
    "digits_between"   => "O :attribute deve ter entre :min e :max dígitos.",
    "email"            => "O formato de :attribute é inválido.",
    "exists"           => "O :attribute selecionado é inválido.",
    "email_array"      => "Um ou mais endereços de email são invalidos.",
    "image"            => "O :attribute deve ser uma imagem.",
    "in"               => "O :attribute selecionado é inválido.",
    "integer"          => "O :attribute deve ser um número inteiro.",
    "ip"               => "O :attribute deve ser um endereço de IP válido.",
    "max"              => array(
        "numeric" => "O :attribute não pode ser maior do que :max.",
        "file"    => "O :attribute não pode ser maior do que :max kilobytes.",
        "string"  => "O :attribute não pode ser maior do que :max caracteres.",
    ),
    "mimes"            => "O :attribute deve ser um arquivo do tipo: :values.",
    "min"              => array(
        "numeric" => "O :attribute deve ter pelo menos :min.",
        "file"    => "O :attribute deve ter pelo menos :min kilobytes.",
        "string"  => "O :attribute deve ter pelo menos :min caracteres.",
    ),
    "not_in"           => "O :attribute selecionado é inválido.",
    "numeric"          => "O :attribute deve ser um número.",
    "regex"            => "O formato de :attribute é inválido.",
    "required"         => "O campo de :attribute é requerido.",
    "required_if"      => "O campo de :attribute é requerido quando :other é :value.",
    "required_with"    => "O campo de :attribute é requerido quando :values está presente.",
    "required_without" => "O campo de :attribute é requerido quando :values não está presente.",
    "same"             => "O :attribute e :other devem corresponderem.",
    "size"             => array(
        "numeric" => "O :attribute deve ser :size.",
        "file"    => "O :attribute deve ter :size kilobytes.",
        "string"  => "O :attribute deve ter :size caracteres.",
    ),
    "unique"           => "O :attribute já foi tomado.",
    "url"              => "O formato de :attribute é inválido.",
    "statuslabel_type" => "Você deve selecionar um tipo de rótulo de status válido",
    "unique_undeleted" => "O :attribute deve ser exclusivo.",


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

    'custom' => array(),
    'alpha_space' => "O campo :attribute contém um caractere que não é permitido.",

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

    'attributes' => array(),

);
