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

    'accepted'             => ':attribute должен быть принят.',
    'active_url'           => ':attribute некорректный URL.',
    'after'                => 'The :attribute должен быть после :date.',
    'after_or_equal'       => 'Атрибут: должен быть датой после или равной: дата.',
    'alpha'                => ':attribute может содержать только символы.',
    'alpha_dash'           => ':attribute может содержать только буквы, цифры и тире.',
    'alpha_num'            => ':attribute может содержать только буквы и цифры.',
    'array'                => 'Атрибут: должен быть массивом.',
    'before'               => ':attribute должен быть датой до :date.',
    'before_or_equal'      => 'Атрибут: должен быть дата до или равна: дата.',
    'between'              => [
        'numeric' => ':attribute должен быть между :min - :max.',
        'file'    => ':attribute должен быть между :min - :max килобайт.',
        'string'  => ':attribute должен быть между :min - :max символов.',
        'array'   => 'Атрибут: должен находиться между: min и: max элементами.',
    ],
    'boolean'              => ':attribute должен быть true или false.',
    'confirmed'            => 'Подтверждение :attribute не совпадает.',
    'date'                 => ':attribute неправильная дата.',
    'date_format'          => ':attribute не совпадает с форматом :format.',
    'different'            => ':attribute и :other должны быть разными.',
    'digits'               => ':attribute должен содержать :digits цифр.',
    'digits_between'       => ':attribute должно быть между :min и :max цифр.',
    'dimensions'           => 'Атрибут: имеет недопустимые размеры изображения.',
    'distinct'             => 'Поле атрибута: имеет двойное значение.',
    'email'                => 'Неправильный формат :attribute.',
    'exists'               => 'Выбранный :attribute неправильный.',
    'file'                 => 'Атрибут: должен быть файлом.',
    'filled'               => 'Поле атрибута: должно иметь значение.',
    'image'                => ':attribute должен быть изображением.',
    'import_field_empty'    => 'Значение :fieldname не может быть пустым.',
    'in'                   => 'Выбранный :attribute неправильный.',
    'in_array'             => 'Поле: атрибут не существует в: other.',
    'integer'              => ':attribute должно быть числом.',
    'ip'                   => ':attribute должно быть IP адресом.',
    'ipv4'                 => 'Атрибут: должен быть действительным адресом IPv4.',
    'ipv6'                 => 'Атрибут: должен быть действительным адресом IPv6.',
    'is_unique_department' => ':attribute должен быть уникальным для этого местоположения компании',
    'json'                 => 'Атрибут: должен быть действительной строкой JSON.',
    'max'                  => [
        'numeric' => ':attribute не должно быть больше :max.',
        'file'    => ':attribute не должен превышать :max килобайт.',
        'string'  => ':attribute не должно превышать :max символов.',
        'array'   => 'Атрибут: может быть не больше: max элементов.',
    ],
    'mimes'                => ':attribute тип файла должен быть: :values.',
    'mimetypes'            => 'Атрибут: должен быть файл типа:: values.',
    'min'                  => [
        'numeric' => ':attribute должно быть не менее :min.',
        'file'    => ':attribute должно быть не менее :min килобайт.',
        'string'  => ':attribute должно быть не менее :min символов.',
        'array'   => 'Атрибут: должен содержать не менее: мин.',
    ],
    'starts_with'          => ':attribute должен начинаться с одного из следующих значений: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => 'Выбранный :attribute неправильный.',
    'numeric'              => ':attribute должно быть числом.',
    'present'              => 'Поле атрибута: должно присутствовать.',
    'valid_regex'          => 'Это не верно составленное регулярное выражение. ',
    'regex'                => 'Неправильный формат :attribute.',
    'required'             => ':attribute обязательное поле.',
    'required_if'          => ':attribute обязательное поле, когда :other :value.',
    'required_unless'      => 'Поле атрибута: требуется, если: other находится в: значения.',
    'required_with'        => ':attribute обязательное поле, когда присутствует :values.',
    'required_with_all'    => 'Поле атрибута: требуется, когда: есть значения.',
    'required_without'     => ':attribute обязательное поле, когда отсутствует :values.',
    'required_without_all' => 'Поле атрибута: требуется, если ни один из: значений не присутствует.',
    'same'                 => ':attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => ':attribute должен быть :size.',
        'file'    => ':attribute должен быть :size килобайт.',
        'string'  => ':attribute должен быть :size символов.',
        'array'   => 'Атрибут: должен содержать: элементы размера.',
    ],
    'string'               => 'Атрибут: должен быть строкой.',
    'timezone'             => 'Атрибут: должен быть допустимой зоной.',
    'unique'               => ':attribute уже занят.',
    'uploaded'             => 'Атрибут: не удалось загрузить.',
    'url'                  => 'Неправильный формат :attribute.',
    'unique_undeleted'     => 'Свойство :attribute должно быть уникальным.',
    'non_circular'         => ':attribute не должен создавать циклическую ссылку.',
    'disallow_same_pwd_as_user_fields' => 'Пароль не может совпадать с именем пользователя.',
    'letters'              => 'Пароль должен содержать хотя бы одну букву.',
    'numbers'              => 'Пароль должен содержать хотя бы одну цифру.',
    'case_diff'            => 'Пароль должен использовать смешанный регистр.',
    'symbols'              => 'Пароль должен содержать символы.',
    'gte'                  => [
        'numeric'          => 'Значение не может быть отрицательным'
    ],


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
        'alpha_space' => 'Поле атрибута: содержит символ, который не разрешен.',
        'email_array'      => 'Один или несколько адресов электронной почты недействительны.',
        'hashed_pass'      => 'Ваш текущий пароль неверен',
        'dumbpwd'          => 'Этот пароль слишком распространен.',
        'statuslabel_type' => 'Вы должны выбрать допустимый тип метки статуса',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute должен быть допустимой датой в формате YYYY-MM-DD',
        'last_audit_date.date_format'   =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD hh:mm:ss',
        'expiration_date.date_format'   =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD',
        'termination_date.date_format'  =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD',
        'expected_checkin.date_format'  =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD',
        'start_date.date_format'        =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD',
        'end_date.date_format'          =>  ':attribute должен быть допустимой датой в формате YYYY-MM-DD',

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

];
