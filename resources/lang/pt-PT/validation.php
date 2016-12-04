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

    "accepted"         => "O :attribute tem que ser aceite.",
    "active_url"       => "O :attribute não é um URL válido.",
    "after"            => "A :attribute tem que ser superior a :date.",
    "alpha"            => "O :attribute só pode conter letras.",
    "alpha_dash"       => "O :attribute só pode conter letras, números e traços.",
    "alpha_num"        => "O :attribute só pode conter letras e números.",
    "before"           => "A :attribute tem que ser anterior a :date.",
    "between"          => array(
        "numeric" => "O :attribute deve estar entre :min e :max.",
        "file"    => "O :attribute deve estar entre :min e :max kilobytes.",
        "string"  => "O :attribute deve estar entre :min e :max caracteres.",
    ),
    "confirmed"        => "A confirmação da :attribute não coincide.",
    "date"             => "A :attribute não é uma data válida.",
    "date_format"      => ":attribute não corresponde ao formato :format.",
    "different"        => ":attribute e :other têm que ser diferentes.",
    "digits"           => ":attribute de contem :digits dígitos.",
    "digits_between"   => "O :attribute deve estar entre :min e :max dígitos.",
    "email"            => "O formato do :attribute é inválido.",
    "exists"           => "O :attribute é inválido.",
    "email_array"      => "Um ou mais endereços de email são invalidos.",
    "image"            => "O :attribute tem que ser uma imagem.",
    "in"               => "O :attribute selecionado é inválido.",
    "integer"          => "O :attribute tem que ser um inteiro.",
    "ip"               => "O :attribute tem que ser um IP válido.",
    "max"              => array(
        "numeric" => "O :attribute não pode ser maior do que :max.",
        "file"    => "O :attribute não pode ter mais do que :max kilobytes.",
        "string"  => "O :attribute não pode tem mais do que :max caracteres.",
    ),
    "mimes"            => "O :attribute só pode contem os seguintes formatos: :values.",
    "min"              => array(
        "numeric" => ":attribute deve ter pelos menos :min.",
        "file"    => ":attribute deve ter pelos menos :min kilobytes.",
        "string"  => "O :attribute deve conter pelos menos :min caracteres.",
    ),
    "not_in"           => "O :attribute selecionado é inválido.",
    "numeric"          => ":attribute tem que ser um número.",
    "regex"            => "O formato do :attribute é inválido.",
    "required"         => ":attribute é obrigatório.",
    "required_if"      => "O :attribute é obrigatório quando :other é :value.",
    "required_with"    => "O :attribute é obrigatório quando :values existem.",
    "required_without" => "O :attribute é obrigatório quando :values não existem.",
    "same"             => ":attribute e :other devem coincidir.",
    "size"             => array(
        "numeric" => "O :attribute deve ser maior que :size.",
        "file"    => "O :attribute deve ter :size kilobytes.",
        "string"  => "O :attribute deve conter :size caracteres.",
    ),
    "unique"           => "Este :attribute já existe.",
    "url"              => "O formato do :attribute é inválido.",
    "statuslabel_type" => "Deve selecionar um tipo de rótulo de estado valido",
    "unique_undeleted" => "O :atribute deve ser único.",


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
    'alpha_space' => "O :attribute contem um caracter que não é permitido.",

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
