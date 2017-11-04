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

    'accepted'             => ':attribute трябва да бъде потвърден.',
    'active_url'           => ':attribute не е валиден URL адрес.',
    'after'                => ':attribute трябва да бъде дата след :date.',
    'after_or_equal'       => 'Атрибутът: трябва да бъде дата след или равна на: дата.',
    'alpha'                => ':attribute може да съдържа единствено букви.',
    'alpha_dash'           => ':attribute може да съдържа единствено букви, числа и тире.',
    'alpha_num'            => ':attribute може да съдържа единствено букви и числа.',
    'array'                => 'Атрибутът: трябва да бъде масив.',
    'before'               => ':attribute трябва да бъде дата преди :date.',
    'before_or_equal'      => 'Атрибутът: трябва да бъде дата преди или равна на: дата.',
    'between'              => [
        'numeric' => ':attribute трябва да бъде между :min и :max.',
        'file'    => ':attribute трябва да бъде с големина между :min и :max KB.',
        'string'  => ':attribute трябва да бъде с дължина между :min и :max символа.',
        'array'   => 'Атрибутът: трябва да има между: min и: max items.',
    ],
    'boolean'              => ':attribute трябва да е верен или грешен.',
    'confirmed'            => ':attribute потвърждение не съвпада.',
    'date'                 => ':attribute не е валидна дата.',
    'date_format'          => ':attribute не съвпада с формата :format.',
    'different'            => ':attribute и :other трябва да се различават.',
    'digits'               => ':attribute трябва да бъде с дължина :digits цифри.',
    'digits_between'       => ':attribute трябва да бъде с дължина между :min и :max цифри.',
    'dimensions'           => 'Атрибутът: има невалидни величини на изображението.',
    'distinct'             => 'Полето: atribut има дублираща се стойност.',
    'email'                => ':attribute е с невалиден формат.',
    'exists'               => 'Избраният :attribute е невалиден.',
    'file'                 => 'Атрибутът: трябва да е файл.',
    'filled'               => 'Полето на атрибута: трябва да има стойност.',
    'image'                => ':attribute трябва да бъде изображение.',
    'in'                   => 'Избраният :attribute е невалиден.',
    'in_array'             => 'Полето: atribut не съществува в: други.',
    'integer'              => ':attribute трябва да бъде целочислен.',
    'ip'                   => ':attribute трябва да бъде валиден IP адрес.',
    'ipv4'                 => 'Атрибутът: трябва да е валиден IPv4 адрес.',
    'ipv6'                 => 'Атрибутът: трябва да е валиден IPv6 адрес.',
    'json'                 => 'Атрибутът: трябва да е валиден низ на JSON.',
    'max'                  => [
        'numeric' => ':attribute не може да бъде по-дълъг от :max.',
        'file'    => ':attribute не може да бъде по-голям от :max KB.',
        'string'  => ':attribute не може да бъде по-дълъг от :max символа.',
        'array'   => 'Атрибутът: не може да има повече от: max items.',
    ],
    'mimes'                => ':attribute трябва да бъде файл с един от следните типове: :values.',
    'mimetypes'            => 'Атрибутът: трябва да бъде файл от тип:: стойности.',
    'min'                  => [
        'numeric' => ':attribute трябва да бъде минимум :min.',
        'file'    => ':attribute трябва да бъде с големина минимум :min KB.',
        'string'  => ':attribute трябва да бъде минимум :min символа.',
        'array'   => 'Атрибутът: трябва да има поне: min елементи.',
    ],
    'not_in'               => 'Избраният :attribute е невалиден.',
    'numeric'              => ':attribute трябва да бъде число.',
    'present'              => 'Полето на атрибута трябва да е налице.',
    'regex'                => 'Форматът на :attribute е невалиден.',
    'required'             => 'Полето :attribute е задължително.',
    'required_if'          => 'Полето :attribute е задължително, когато :other е :value.',
    'required_unless'      => 'Полето: атрибут се изисква, освен ако: другият не е в: стойности.',
    'required_with'        => ':attribute е задължителен, когато са избрани :values.',
    'required_with_all'    => 'Полето: атрибут се изисква, когато: стойностите са налице.',
    'required_without'     => ':attribute е задължителен, когато не са избрани :values.',
    'required_without_all' => 'Полето: атрибут се изисква, когато няма стойности: стойности.',
    'same'                 => ':attribute и :other трябва да съвпадат.',
    'size'                 => [
        'numeric' => ':attribute трябва да бъде с дължина :size.',
        'file'    => ':attribute трябва да бъде с големина :size KB.',
        'string'  => ':attribute трябва да бъде с дължина :size символа.',
        'array'   => 'Атрибутът: трябва да съдържа: размерни елементи.',
    ],
    'string'               => 'Атрибутът: трябва да е низ.',
    'timezone'             => 'Атрибутът: трябва да е валидна зона.',
    'unique'               => ':attribute вече е вписан.',
    'uploaded'             => 'Атрибутът: не успя да качи.',
    'url'                  => 'Форматът на :attribute е невалиден.',
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
        'alpha_space' => "Полето атрибут: съдържа знак, който не е разрешен.",
        "email_array"      => "Един или повече имейл адреси са невалидни.",
        "hashed_pass"      => "Текущата ви парола е неправилна",
        'dumbpwd'          => 'Тази парола е твърде често срещана.',
        "statuslabel_type" => "Трябва да изберете валиден тип етикет на състоянието",
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
