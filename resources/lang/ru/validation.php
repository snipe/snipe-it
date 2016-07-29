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

    "accepted"         => ":attribute должен быть принят.",
    "active_url"       => ":attribute некорректный URL.",
    "after"            => "The :attribute должен быть после :date.",
    "alpha"            => ":attribute может содержать только символы.",
    "alpha_dash"       => ":attribute может содержать только буквы, цифры и тире.",
    "alpha_num"        => ":attribute может содержать только буквы и цифры.",
    "before"           => ":attribute должен быть датой до :date.",
    "between"          => array(
        "numeric" => ":attribute должен быть между :min - :max.",
        "file"    => ":attribute должен быть между :min - :max килобайт.",
        "string"  => ":attribute должен быть между :min - :max символов.",
    ),
    "confirmed"        => "Подтверждение :attribute не совпадает.",
    "date"             => ":attribute неправильная дата.",
    "date_format"      => ":attribute не совпадает с форматом :format.",
    "different"        => ":attribute и :other должны быть разными.",
    "digits"           => ":attribute должен содержать :digits цифр.",
    "digits_between"   => ":attribute должно быть между :min и :max цифр.",
    "email"            => "Неправильный формат :attribute.",
    "exists"           => "Выбранный :attribute неправильный.",
    "email_array"      => "Один или несколько адресов эл. почты являются недействительным.",
    "image"            => ":attribute должен быть изображением.",
    "in"               => "Выбранный :attribute неправильный.",
    "integer"          => ":attribute должно быть числом.",
    "ip"               => ":attribute должно быть IP адресом.",
    "max"              => array(
        "numeric" => ":attribute не должно быть больше :max.",
        "file"    => ":attribute не должен превышать :max килобайт.",
        "string"  => ":attribute не должно превышать :max символов.",
    ),
    "mimes"            => ":attribute тип файла должен быть: :values.",
    "min"              => array(
        "numeric" => ":attribute должно быть не менее :min.",
        "file"    => ":attribute должно быть не менее :min килобайт.",
        "string"  => ":attribute должно быть не менее :min символов.",
    ),
    "not_in"           => "Выбранный :attribute неправильный.",
    "numeric"          => ":attribute должно быть числом.",
    "regex"            => "Неправильный формат :attribute.",
    "required"         => ":attribute обязательное поле.",
    "required_if"      => ":attribute обязательное поле, когда :other :value.",
    "required_with"    => ":attribute обязательное поле, когда присутствует :values.",
    "required_without" => ":attribute обязательное поле, когда отсутствует :values.",
    "same"             => ":attribute и :other должны совпадать.",
    "size"             => array(
        "numeric" => ":attribute должен быть :size.",
        "file"    => ":attribute должен быть :size килобайт.",
        "string"  => ":attribute должен быть :size символов.",
    ),
    "unique"           => ":attribute уже занят.",
    "url"              => "Неправильный формат :attribute.",
    "statuslabel_type" => "You must select a valid status label type",
    "unique_undeleted" => "The :attribute must be unique.",


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
    'alpha_space' => "Поле :attribute содержит запрещенные символы.",

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
