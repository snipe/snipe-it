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

    "accepted"         => ":attribute debe ser aceptado.",
    "active_url"       => ":attribute no es una URL correcta.",
    "after"            => ":attribute debe ser posterior a :date.",
    "alpha"            => ":attribute solo acepta letras.",
    "alpha_dash"       => ":attribute solo acepta letras, números y guiones.",
    "alpha_num"        => ":attribute solo acepta letras y números.",
    "before"           => ":attribute debe ser anterior a :date.",
    "between"          => array(
        "numeric" => ":attribute debe estar entre :min - :max.",
        "file"    => ":attribute debe estar entre :min - :max kilobytes.",
        "string"  => ":attribute debe estar entre :min - :max caracteres.",
    ),
    "confirmed"        => ":attribute la confirmación no coincide.",
    "date"             => ":attribute no es una fecha correcta.",
    "date_format"      => ":attribute no cumple el formato :format.",
    "different"        => ":attribute y :other deben ser diferentes.",
    "digits"           => ":attribute debe tener :digits dígitos.",
    "digits_between"   => ":attribute debe tener entre :min y :max dígitos.",
    "email"            => ":attribute formato incorrecto.",
    "exists"           => "El :attribute seleccionado no es correcto.",
    "email_array"      => "Una o más direcciones de correo electrónico no es válido.",
    "image"            => ":attribute debe ser una imagen.",
    "in"               => "El :attribute seleccionado no es correcto.",
    "integer"          => ":attribute debe ser un número entero.",
    "ip"               => ":attribute debe ser una dirección IP correcta.",
    "max"              => array(
        "numeric" => ":attribute no debe ser mayor que :max.",
        "file"    => ":attribute no debe ser mayor que :max kilobytes.",
        "string"  => ":attribute no debe tener como máximo :max caracteres.",
    ),
    "mimes"            => ":attribute debe ser un archivo del tipo: :values.",
    "min"              => array(
        "numeric" => ":attribute debe ser como mínimo :min.",
        "file"    => ":attribute debe ser como mínimo de :min kilobytes.",
        "string"  => ":attribute debe contener como mínimo :min caracteres.",
    ),
    "not_in"           => "El :attribute seleccionado no es correcto.",
    "numeric"          => ":attribute debe ser un número.",
    "regex"            => ":attribute formato incorrecto.",
    "required"         => ":attribute es obligatorio.",
    "required_if"      => ":attribute es obligatrio cuando :other es :value.",
    "required_with"    => ":attribute es obligatrio cuando :values es present.",
    "required_without" => ":attribute es obligatrio cuando :values es not present.",
    "same"             => ":attribute y :other deben coincidir.",
    "size"             => array(
        "numeric" => ":attribute debe tener :size.",
        "file"    => ":attribute debe tener :size kilobytes.",
        "string"  => ":attribute debe tener :size caracteres.",
    ),
    "unique"           => ":attribute ya ha sido introducido.",
    "url"              => ":attribute formato incorrecto.",
    "statuslabel_type" => "Debe seleccionar un tipo de etiqueta de estado válido",
    "unique_undeleted" => ":attribute debe ser único.",


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
    'alpha_space' => "El campo :attribute contiene un caracter que no está permitido.",

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
