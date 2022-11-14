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

    'accepted'             => 'Үүнд: аттрибут хүлээн авах ёстой.',
    'active_url'           => 'Үүнд: атрибут нь зөв URL биш байна.',
    'after'                => 'Үүнд: аттрибут нь дараах огноо байх ёстой: date.',
    'after_or_equal'       => 'Үүнд: аттрибут нь дараах огноо эсвэл тэнцүү байх огноо байх ёстой.',
    'alpha'                => 'Үүнд: аттрибут нь зөвхөн үсэг агуулдаг.',
    'alpha_dash'           => 'Үүнд: аттрибут нь зөвхөн үсэг, тоо, зураас агуулсан байж болно.',
    'alpha_num'            => 'Үүнд: аттрибут нь зөвхөн үсэг, тоо агуулж болно.',
    'array'                => 'Үүнд: атрибут нь массив байх ёстой.',
    'before'               => 'Үүнд: аттрибут нь огноогоос өмнө он сар байх ёстой.',
    'before_or_equal'      => 'Үүнд: аттрибут нь огноогоос өмнө эсвэл огноо байх ёстой.',
    'between'              => [
        'numeric' => 'Үүнд: атрибут нь дараах байх ёстой: min ба: max.',
        'file'    => 'Үүнд: аттрибут нь: min ба: max килобайт хооронд байх ёстой.',
        'string'  => 'Үүнд: аттрибут нь дараах байх ёстой: min ба: max тэмдэгтүүд.',
        'array'   => 'Үүнд: аттрибут нь дараах байх ёстой: min ба: max items.',
    ],
    'boolean'              => 'Үүнд: аттрибутын талбар нь үнэн эсвэл худал байна.',
    'confirmed'            => 'Үүнд: атрибут баталгаажуулалт таарахгүй байна.',
    'date'                 => 'Үүнд: атрибут нь хүчинтэй хугацаа биш.',
    'date_format'          => 'Үүнд: атрибут формат хэлбэрээр тохирохгүй байна.',
    'different'            => 'Үүнд: аттрибут болон бусад нь өөр байх ёстой.',
    'digits'               => 'Үүнд: аттрибут нь: цифрүүд цифр байна.',
    'digits_between'       => 'Үүнд: аттрибут нь дараах байх ёстой: min ба: хамгийн их цифрүүд.',
    'dimensions'           => 'Үүнд: атрибут буруу зургийн хэмжээстэй байна.',
    'distinct'             => 'Үүнд: атрибутын талбар нь давхар утгатай.',
    'email'                => 'Үүнд: атрибут нь зөв имэйл хаяг байх ёстой.',
    'exists'               => 'Сонгосон: шинж чанар буруу байна.',
    'file'                 => 'Үүнд: атрибут нь файл байх ёстой.',
    'filled'               => 'Үүнд: аттрибутын талбар нь утгатай байх ёстой.',
    'image'                => 'Үүнд: атрибут нь зураг байх ёстой.',
    'in'                   => 'Сонгосон: шинж чанар буруу байна.',
    'in_array'             => 'Үүнд: атрибутын талбар байхгүй байна: бусад.',
    'integer'              => 'Үүнд: атрибут нь бүхэл тоо байх ёстой.',
    'ip'                   => 'Үүнд: атрибут нь зөв IP хаяг байх ёстой.',
    'ipv4'                 => 'Үүнд: атрибут нь хүчин төгөлдөр IPv4 хаяг байх ёстой.',
    'ipv6'                 => 'Үүнд: аттрибут нь зөв IPv6 хаяг байх ёстой.',
    'json'                 => 'Үүнд: атрибут нь JSON тэмдэгт байх ёстой.',
    'max'                  => [
        'numeric' => 'Үүнд: аттрибут нь: max.',
        'file'    => 'Үүнд: аттрибут нь: килобайтаас ихгүй байж болно.',
        'string'  => 'Үүнд: аттрибут нь хамгийн их тэмдэгтүүдээс их байж болохгүй.',
        'array'   => 'Үүнд: аттрибут нь дараахи зүйлсээс ихгүй байна.',
    ],
    'mimes'                => 'Үүнд: аттрибут нь төрөл:: утгуудтай файл байх ёстой.',
    'mimetypes'            => 'Үүнд: аттрибут нь төрөл:: утгуудтай файл байх ёстой.',
    'min'                  => [
        'numeric' => 'Үүнд: аттрибут дор хаяж байх ёстой.',
        'file'    => 'Үүнд: атрибут дор хаяж нэг килобайт байх ёстой.',
        'string'  => 'Үүнд: атрибут дор хаяж байх ёстой: min тэмдэгтүүд.',
        'array'   => 'Үүнд: атрибут дор хаяж дараах зүйлсийг агуулсан байх ёстой.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Сонгосон: шинж чанар буруу байна.',
    'numeric'              => 'Үүнд: атрибут нь тоо байх ёстой.',
    'present'              => 'Үүнд: атрибутын талбар байх ёстой.',
    'valid_regex'          => 'Энэ regex нь хүчин төгөлдөр биш. ',
    'regex'                => 'Агуулга формат буруу байна.',
    'required'             => 'Үүнд: атрибутын талбар шаардлагатай.',
    'required_if'          => 'Үүнд: аттрибутын талбар шаардлагатай үед: бусад нь: утга.',
    'required_unless'      => 'Үүнд: аттрибутын талбар шаардлагатай: бусад нь: утга байна.',
    'required_with'        => 'Үүнд: аттрибутын талбар шаардлагатай бол: утга байгаа болно.',
    'required_with_all'    => 'Үүнд: аттрибутын талбар шаардлагатай бол: утга байгаа болно.',
    'required_without'     => 'Үүнд: аттрибутын талбар шаардлагатай үед: утга байхгүй байна.',
    'required_without_all' => 'Үүнд: аттрибутын талбар нь: утга байх ёсгүй.',
    'same'                 => 'Үүнд: атрибут болон бусад нь таарах ёстой.',
    'size'                 => [
        'numeric' => 'Үүнд: атрибут нь байх ёстой: хэмжээ.',
        'file'    => 'Үүнд: атрибут нь: хэмжээ килобайт байх ёстой.',
        'string'  => 'Үүнд: аттрибут нь: хэмжээст тэмдэгтүүд.',
        'array'   => 'Үүнд: атрибут нь дараах хэмжээтэй байна: size items.',
    ],
    'string'               => 'Үүнд: атрибут нь мөр байх ёстой.',
    'timezone'             => 'Үүнд: атрибут нь хүчинтэй бүс байх ёстой.',
    'unique'               => 'Үүнд: атрибут аль хэдийн авсан байна.',
    'uploaded'             => 'Үүнд: атрибут байршуулах боломжгүй байна.',
    'url'                  => 'Агуулга формат буруу байна.',
    'unique_undeleted'     => ':attribute дахин давтагдашгүй байх ёстой.',
    'non_circular'         => 'The :attribute must not create a circular reference.',
    'disallow_same_pwd_as_user_fields' => 'Password cannot be the same as the username.',
    'letters'              => 'Password must contain at least one letter.',
    'numbers'              => 'Password must contain at least one number.',
    'case_diff'            => 'Password must use mixed case.',
    'symbols'              => 'Password must contain symbols.',
    'gte'                  => [
        'numeric'          => 'Value cannot be negative'
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
        'alpha_space' => 'Үүнд: аттрибут талбар нь зөвшөөрөгдөөгүй тэмдэгт агуулна.',
        'email_array'      => 'Нэг буюу хэд хэдэн имэйл хаяг буруу байна.',
        'hashed_pass'      => 'Таны одоогийн нууц үг буруу байна',
        'dumbpwd'          => 'Энэ нууц үг хэтэрхий нийтлэг байна.',
        'statuslabel_type' => 'Та зөв статустай шошгын төрлийг сонгох ёстой',
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
