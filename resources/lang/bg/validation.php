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

    "accepted"         => ":attribute трябва да бъде потвърден.",
    "active_url"       => ":attribute не е валиден URL адрес.",
    "after"            => ":attribute трябва да бъде дата след :date.",
    "alpha"            => ":attribute може да съдържа единствено букви.",
    "alpha_dash"       => ":attribute може да съдържа единствено букви, числа и тире.",
    "alpha_num"        => ":attribute може да съдържа единствено букви и числа.",
    "before"           => ":attribute трябва да бъде дата преди :date.",
    "between"          => array(
        "numeric" => ":attribute трябва да бъде между :min и :max.",
        "file"    => ":attribute трябва да бъде с големина между :min и :max KB.",
        "string"  => ":attribute трябва да бъде с дължина между :min и :max символа.",
    ),
    "confirmed"        => ":attribute потвърждение не съвпада.",
    "date"             => ":attribute не е валидна дата.",
    "date_format"      => ":attribute не съвпада с формата :format.",
    "different"        => ":attribute и :other трябва да се различават.",
    "digits"           => ":attribute трябва да бъде с дължина :digits цифри.",
    "digits_between"   => ":attribute трябва да бъде с дължина между :min и :max цифри.",
    "email"            => ":attribute е с невалиден формат.",
    "exists"           => "Избраният :attribute е невалиден.",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute трябва да бъде изображение.",
    "in"               => "Избраният :attribute е невалиден.",
    "integer"          => ":attribute трябва да бъде целочислен.",
    "ip"               => ":attribute трябва да бъде валиден IP адрес.",
    "max"              => array(
        "numeric" => ":attribute не може да бъде по-дълъг от :max.",
        "file"    => ":attribute не може да бъде по-голям от :max KB.",
        "string"  => ":attribute не може да бъде по-дълъг от :max символа.",
    ),
    "mimes"            => ":attribute трябва да бъде файл с един от следните типове: :values.",
    "min"              => array(
        "numeric" => ":attribute трябва да бъде минимум :min.",
        "file"    => ":attribute трябва да бъде с големина минимум :min KB.",
        "string"  => ":attribute трябва да бъде минимум :min символа.",
    ),
    "not_in"           => "Избраният :attribute е невалиден.",
    "numeric"          => ":attribute трябва да бъде число.",
    "regex"            => "Форматът на :attribute е невалиден.",
    "required"         => "Полето :attribute е задължително.",
    "required_if"      => "Полето :attribute е задължително, когато :other е :value.",
    "required_with"    => ":attribute е задължителен, когато са избрани :values.",
    "required_without" => ":attribute е задължителен, когато не са избрани :values.",
    "same"             => ":attribute и :other трябва да съвпадат.",
    "size"             => array(
        "numeric" => ":attribute трябва да бъде с дължина :size.",
        "file"    => ":attribute трябва да бъде с големина :size KB.",
        "string"  => ":attribute трябва да бъде с дължина :size символа.",
    ),
    "unique"           => ":attribute вече е вписан.",
    "url"              => "Форматът на :attribute е невалиден.",
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
    'alpha_space' => ":attribute съдържа символи, които са забранени.",

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
