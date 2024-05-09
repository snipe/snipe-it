<?php

return [

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

    'accepted'             => 'Ви повинні прийняти :attribute.',
    'active_url'           => 'Поле :attribute не є правильним URL.',
    'after'                => 'Поле :attribute має містити дату не раніше :date.',
    'after_or_equal'       => 'Поле :attribute має містити дату не раніше або дорівнювати :date.',
    'alpha'                => 'Поле :attribute має містити лише літери.',
    'alpha_dash'           => 'Поле :attribute має містити лише літери, цифри та тире.',
    'alpha_num'            => 'Поле :attribute має містити лише літери та цифри.',
    'array'                => 'Поле :attribute має бути масивом.',
    'before'               => 'Поле :attribute має містити дату не пізніше :date.',
    'before_or_equal'      => 'Поле :attribute має містити дату не пізніше або дорівнювати :date.',
    'between'              => [
        'numeric' => 'Поле :attribute має бути між :min - :max.',
        'file'    => 'Розмір :attribute має бути в межах від :min - :max кілобайт.',
        'string'  => 'Текст в полі :attribute має бути не менше :min - :max символів.',
        'array'   => 'Поле :attribute має бути між :min та :max елементами.',
    ],
    'boolean'              => 'Поле :attribute повинне містити значення true або false.',
    'confirmed'            => 'Підтвердження для :attribute не співпадає.',
    'date'                 => 'Поле :attribute не є датою.',
    'date_format'          => 'Поле :attribute не відповідає формату :format.',
    'different'            => 'Поля :attribute та :other повинні бути різними.',
    'digits'               => 'Довжина цифрового поля :attribute повинна дорівнювати :digits.',
    'digits_between'       => 'Довжина цифрового поля :attribute повинна бути в межах від :min до :max.',
    'dimensions'           => 'Поле :attribute міщує неприпустимі розміри зображення.',
    'distinct'             => 'Значення поля :attribute вже існує.',
    'email'                => 'Формат поля :attribute неправильний.',
    'exists'               => 'Обрана валюта недійсна.',
    'file'                 => 'Поле :attribute має містити файл.',
    'filled'               => 'Поле :attribute повинно бути заповнене.',
    'image'                => ':attribute має бути зображенням.',
    'import_field_empty'    => 'Значення для :fieldname не може бути null.',
    'in'                   => 'Обрана валюта недійсна.',
    'in_array'             => 'Значення поля :attribute не існує в :other.',
    'integer'              => 'Поле :attribute має містити ціле число.',
    'ip'                   => 'Поле :attribute має містити IP адресу.',
    'ipv4'                 => 'Поле :attribute має бути коректною адресою IPv4.',
    'ipv6'                 => ':attribute має бути коректною адресою IPv6.',
    'is_unique_department' => 'Поле :attribute має бути унікальним для даного розташування компанії',
    'json'                 => 'Дані поля :attribute мають бути в форматі JSON.',
    'max'                  => [
        'numeric' => 'Поле :attribute має бути не більше :max.',
        'file'    => ':attribute має бути не більше :max кілобайт.',
        'string'  => 'Текст в полі :attribute повинен містити не більше, ніж :max символів.',
        'array'   => 'Поле :attribute повинне містити не більше :max елементів.',
    ],
    'mimes'                => 'Поле :attribute повинне містити файл одного з типів: :values.',
    'mimetypes'            => 'Поле :attribute повинне містити файл одного з типів: :values.',
    'min'                  => [
        'numeric' => 'Поле :attribute повинне бути не менше :min.',
        'file'    => 'Розмір файлу в полі :attribute має бути не меншим :min кілобайт.',
        'string'  => 'Текст в полі :attribute повинен містити не менше :min символів.',
        'array'   => 'Поле :attribute повинне містити не менше :min елементів.',
    ],
    'starts_with'          => 'Поле :attribute повинне починатися з одного з наступних :values.',
    'ends_with'            => 'Поле :attribute повинне закінчуватися одним з наступних: :values.',

    'not_in'               => 'Обрана валюта недійсна.',
    'numeric'              => 'Поле :attribute має містити число.',
    'present'              => 'Поле :attribute повинне бути присутнім.',
    'valid_regex'          => 'Це не коректний регулярний вираз. ',
    'regex'                => 'Формат поля :attribute неправильний.',
    'required'             => 'Поле :attribute є обов\'язковим для заповнення.',
    'required_if'          => 'Поле :attribute є обов\'язковим для заповнення, коли :other є :value.',
    'required_unless'      => 'Поле :attribute обов\'язкове, якщо :other не з :values.',
    'required_with'        => 'Поле :attribute є обов\'язковим для заповнення, коли :values вказано.',
    'required_with_all'    => 'Поле :attribute є обов\'язковим для заповнення, коли :values вказано.',
    'required_without'     => 'Поле :attribute є обов\'язковим для заповнення, коли :values не вказано.',
    'required_without_all' => 'Поле :attribute є обов\'язковим для заповнення, коли :values не вказано.',
    'same'                 => 'Поля :attribute та :other мають співпадати.',
    'size'                 => [
        'numeric' => 'Поле :attribute має бути довжиною :size.',
        'file'    => ':attribute має бути :size кілобайт.',
        'string'  => ':attribute має бути довжиною :size символів.',
        'array'   => 'Поле :attribute має містити :size елементів.',
    ],
    'string'               => 'Поле :attribute повинне містити текст.',
    'timezone'             => 'Поле :attribute повинне містити коректну часову зону.',
    'two_column_unique_undeleted' => 'Поле :attribute має бути унікальним для :table1 і :table2. ',
    'unique'               => ':attribute вже зайнятий.',
    'uploaded'             => 'Завантаження поля :attribute не вдалося.',
    'url'                  => 'Формат поля :attribute неправильний.',
    'unique_undeleted'     => 'Поле :attribute має бути унікальним.',
    'non_circular'         => 'Поле :attribute не повинне створювати круглие посилання.',
    'not_array'            => ':attribute не може бути масивом.',
    'disallow_same_pwd_as_user_fields' => 'Пароль не може бути таким же, як ім\'я користувача.',
    'letters'              => 'Пароль має містити принаймні одну букву.',
    'numbers'              => 'Пароль має містити принаймні одну цифру.',
    'case_diff'            => 'Пароль повинен використовувати змішаний випадок.',
    'symbols'              => 'Пароль має містити символи.',
    'gte'                  => [
        'numeric'          => 'Значення не може бути від’ємним'
    ],
    'checkboxes'           => ':attribute містить неприпустимі параметри.',
    'radio_buttons'        => ':attribute є неприпустимим.',


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
        'alpha_space' => 'Поле :attribute містить символ, який не допускається.',
        'email_array'      => 'Одна або кілька адрес електронної пошти не правильні.',
        'hashed_pass'      => 'Поточний пароль неправильний',
        'dumbpwd'          => 'Цей пароль занадто вживаний.',
        'statuslabel_type' => 'Ви повинні вибрати правильний тип статуса',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => 'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',
        'last_audit_date.date_format'   =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD hh:mm:ss',
        'expiration_date.date_format'   =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',
        'termination_date.date_format'  =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',
        'expected_checkin.date_format'  =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',
        'start_date.date_format'        =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',
        'end_date.date_format'          =>  'Поле :attribute має містити коректну дату в форматі YYYY-MM-DD',

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

    /*
    |--------------------------------------------------------------------------
    | Generic Validation Messages
    |--------------------------------------------------------------------------
    */
    'invalid_value_in_field' => 'Невірне значення включене в це поле',
];
