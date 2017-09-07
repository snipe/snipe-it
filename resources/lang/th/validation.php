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

    'accepted'             => ':attribute ต้องได้รับการยอมรับ',
    'active_url'           => ':attribute ไม่ใช่ URL ที่ถูกต้อง',
    'after'                => ':attribute ต้องเป็นวันที่หลังจาก :date',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute ต้องมีเฉพาะตัวอักษรเท่านั้น',
    'alpha_dash'           => ':attribute ต้องมีเฉพาะตัวอักษร ตัวเลข หรือเครื่องหมายลบเท่านั้น',
    'alpha_num'            => ':attribute ต้องมีเฉพาะตัวอักษรและตัวเลขเท่านั้น',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min - :max',
        'file'    => ':attribute ต้องมีขนาดระหว่าง :min - :max กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวนระหว่าง :min - :max ตัวอักษร',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute ไม่ตรงกัน',
    'date'                 => ':attribute เป็นรูปแบบวันที่ที่ไม่ถูกต้อง',
    'date_format'          => ':attribute ไม่ตรงตามรูปแบบ :format',
    'different'            => ':attribute และ :other ต้องไม่เหมือนกัน',
    'digits'               => ':attribute ต้องเป็น :digits ตัวเลข',
    'digits_between'       => ':attribute ต้องเป็นตัวเลขระหว่าง :min และ :max',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'exists'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute ต้องเป็นรูปภาพเท่านั้น',
    'in'                   => ':attribute ที่เลือกไม่ถูกต้อง',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute ต้องเป็นจำนวนเต็มเท่านั้น',
    'ip'                   => ':attribute ต้องเป็นรูปแบบไอพีแอดเดรสเท่านั้น',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute ต้องไม่มากกว่า :max',
        'file'    => ':attribute ต้องไม่มีขนาดมากกว่า :max กิโลไบต์',
        'string'  => ':attribute ต้องไม่มีจำนวนตัวอักษรมากกว่า :max ตัวอักษร',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute ต้องเป็นรูปแบบไฟล์ดังนี้: :values',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute ต้องมีอย่างน้อย :min',
        'file'    => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวนอย่างน้อย :min ตัวอักษร',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'numeric'              => ':attribute ต้องเป็นตัวเลขเท่านั้น',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'required'             => 'กรุณากรอกข้อมูลในฟิลด์ :attribute',
    'required_if'          => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :other เป็น :value',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value มีข้อมูลอยู่ด้วย',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value ไม่มีข้อมูล',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute และ :other ต้องตรงกัน',
    'size'                 => [
        'numeric' => ':attribute ต้องมีขนาด :size',
        'file'    => ':attribute ต้องมีขนาด :size กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวน :size ตัวอักษร',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute กำลังใช้งานอยู่',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'รูปแบบของ :attribute ไม่ถูกต้อง',

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
        'alpha_space' => "The :attribute field contains a character that is not allowed.",
        "email_array"      => "One or more email addresses is invalid.",
        "hashed_pass"      => "Your current password is incorrect",
        'dumbpwd'          => 'That password is too common.',
        "statuslabel_type" => "You must select a valid status label type",
        "unique_undeleted" => "The :attribute must be unique.",
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
