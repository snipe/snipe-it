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

    'accepted'             => ':attribute يجب ان يكون مقبولا.',
    'active_url'           => ':attribute موقع غير صحيح.',
    'after'                => ':attribute يجب ان يكون تاريخ قبل :date.',
    'after_or_equal'       => 'يجب أن تكون السمة عبارة عن تاريخ بعد أو يساوي: التاريخ.',
    'alpha'                => 'قد تحتوي السمة على أحرف فقط.',
    'alpha_dash'           => 'قد تحتوي السمة على أحرف وأرقام وشرطات فقط.',
    'alpha_num'            => 'قد تحتوي السمة على أحرف وأرقام فقط.',
    'array'                => 'يجب أن تكون السمة مصفوفة.',
    'before'               => ':attribute يجب ان يكون تاريخ قبل :date.',
    'before_or_equal'      => 'يجب أن تكون السمة عبارة عن تاريخ قبل أو يساوي: ديت.',
    'between'              => [
        'numeric' => ':attribute يجب ان يكون بين :min - :max.',
        'file'    => 'يجب أن تكون السمة: مين و: ماكس كيلوبايت.',
        'string'  => 'يجب أن تكون السمة: مين و: ماكس من الأحرف.',
        'array'   => 'يجب أن تتضمن السمة ما بين: مين و: ماكس من العناصر.',
    ],
    'boolean'              => 'يجب أن يكون حقل السمة صحيحا أو خاطئا.',
    'confirmed'            => 'لا يتطابق تأكيد السمة.',
    'date'                 => ':attribute تاريخ غير صحيح.',
    'date_format'          => 'لا تتطابق السمة: مع التنسيق.',
    'different'            => 'السمة: و أخرى يجب أن تكون مختلفة.',
    'digits'               => 'يجب أن تكون السمة: أرقام الأرقام.',
    'digits_between'       => 'يجب أن تكون السمة: مين و: ماكس ديجيتس.',
    'dimensions'           => 'تحتوي السمة: على أبعاد غير صالحة للصور.',
    'distinct'             => 'يحتوي حقل السمة على قيمة مكررة.',
    'email'                => 'يجب أن تكون السمة عنوان بريد إلكتروني صالحا.',
    'exists'               => 'السمة المحددة: غير صالحة.',
    'file'                 => 'يجب أن تكون السمة ملف.',
    'filled'               => 'يجب أن يحتوي حقل السمة على قيمة.',
    'image'                => 'يجب أن تكون السمة صورة.',
    'in'                   => 'السمة المحددة: غير صالحة.',
    'in_array'             => 'حقل السمة: غير موجود في: أخرى.',
    'integer'              => 'يجب أن تكون السمة عدد صحيح.',
    'ip'                   => 'يجب أن تكون الخاصية المميزة عنوان إب صالحا.',
    'ipv4'                 => 'يجب أن تكون السمة عنوان IPv4 صالحا.',
    'ipv6'                 => 'يجب أن تكون الخاصية المميزة عنوان IPv6 صالح.',
    'json'                 => 'يجب أن تكون السمة سلسلة جسون صالحة.',
    'max'                  => [
        'numeric' => 'قد لا تكون السمة: أكبر من: ماكس.',
        'file'    => 'قد لا تكون السمة: أكبر من كيلوبايت كحد أقصى.',
        'string'  => 'قد لا تكون السمة: أكبر من: الأحرف كحد أقصى.',
        'array'   => 'قد لا تحتوي السمة على أكثر من: الحد الأقصى للعناصر.',
    ],
    'mimes'                => 'يجب أن تكون الخاصية المميزة ملف من النوع:: القيم.',
    'mimetypes'            => 'يجب أن تكون الخاصية المميزة ملف من النوع:: القيم.',
    'min'                  => [
        'numeric' => 'يجب أن تكون السمة: على الأقل: دقيقة.',
        'file'    => 'يجب أن تكون السمة: على الأقل كيلوبايت.',
        'string'  => 'يجب أن تكون السمة: مين على الأقل.',
        'array'   => 'يجب أن تحتوي السمة على الأقل على: مين من العناصر.',
    ],
    'not_in'               => 'السمة المحددة: غير صالحة.',
    'numeric'              => 'يجب أن تكون السمة رقم.',
    'present'              => 'يجب أن يكون حقل السمة موجود.',
    'regex'                => 'تنسيق السمة: غير صالح.',
    'required'             => 'حقل السمة: مطلوب.',
    'required_if'          => 'حقل السمة: مطلوب عند: أوثر إس: فالو.',
    'required_unless'      => 'حقل السمة: مطلوب ما لم: الآخر في: القيم.',
    'required_with'        => 'حقل السمة: مطلوب عند: القيم موجودة.',
    'required_with_all'    => 'حقل السمة: مطلوب عند: القيم موجودة.',
    'required_without'     => 'حقل السمة: مطلوب عند: القيم غير موجودة.',
    'required_without_all' => 'حقل السمة: مطلوب عند عدم وجود: القيم موجودة.',
    'same'                 => ': السمة و: يجب أن تطابق أخرى.',
    'size'                 => [
        'numeric' => 'يجب أن تكون السمة: سيز.',
        'file'    => 'يجب أن تكون السمة: كيلوبايت بحجم.',
        'string'  => 'يجب أن تكون السمة: سيز تشاراكترز.',
        'array'   => 'يجب أن تحتوي السمة على: حجم العناصر.',
    ],
    'string'               => 'يجب أن تكون السمة عبارة عن سلسلة.',
    'timezone'             => 'يجب أن تكون السمة منطقة صالحة.',
    'unique'               => 'تم أخذ السمة: بالفعل.',
    'uploaded'             => 'أخفق تحميل السمة:.',
    'url'                  => 'تنسيق السمة: غير صالح.',
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
        'alpha_space' => "يحتوي حقل السمة على حرف غير مسموح به.",
        "email_array"      => "عنوان بريد إلكتروني واحد أو أكثر غير صالح.",
        "hashed_pass"      => "كلمة المرور الحالية غير صحيحة",
        'dumbpwd'          => 'كلمة المرور هذه شائعة جدا.',
        "statuslabel_type" => "يجب تحديد نوع تصنيف حالة صالح",
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
