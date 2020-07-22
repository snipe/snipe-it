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
    'after_or_equal'       => 'แอตทริบิวต์: ต้องเป็นวันที่หลังจากหรือเท่ากับ: date',
    'alpha'                => ':attribute ต้องมีเฉพาะตัวอักษรเท่านั้น',
    'alpha_dash'           => ':attribute ต้องมีเฉพาะตัวอักษร ตัวเลข หรือเครื่องหมายลบเท่านั้น',
    'alpha_num'            => ':attribute ต้องมีเฉพาะตัวอักษรและตัวเลขเท่านั้น',
    'array'                => 'แอตทริบิวต์: ต้องเป็นอาร์เรย์',
    'before'               => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal'      => 'แอตทริบิวต์: ต้องเป็นวันที่ก่อนหรือเท่ากับ: date',
    'between'              => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min - :max',
        'file'    => ':attribute ต้องมีขนาดระหว่าง :min - :max กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวนระหว่าง :min - :max ตัวอักษร',
        'array'   => 'แอตทริบิวต์: ต้องมีระหว่าง: min และ: max items',
    ],
    'boolean'              => 'ฟิลด์แอ็ตทริบิวต์: ต้องเป็น true หรือ false',
    'confirmed'            => ':attribute ไม่ตรงกัน',
    'date'                 => ':attribute เป็นรูปแบบวันที่ที่ไม่ถูกต้อง',
    'date_format'          => ':attribute ไม่ตรงตามรูปแบบ :format',
    'different'            => ':attribute และ :other ต้องไม่เหมือนกัน',
    'digits'               => ':attribute ต้องเป็น :digits ตัวเลข',
    'digits_between'       => ':attribute ต้องเป็นตัวเลขระหว่าง :min และ :max',
    'dimensions'           => 'แอตทริบิวต์: มีมิติข้อมูลภาพที่ไม่ถูกต้อง',
    'distinct'             => 'ฟิลด์แอ็ตทริบิวต์: มีค่าซ้ำกัน',
    'email'                => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'exists'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'file'                 => 'แอตทริบิวต์: ต้องเป็นไฟล์',
    'filled'               => 'ฟิลด์แอ็ตทริบิวต์ต้องมีค่า',
    'image'                => ':attribute ต้องเป็นรูปภาพเท่านั้น',
    'in'                   => ':attribute ที่เลือกไม่ถูกต้อง',
    'in_array'             => 'ฟิลด์แอ็ตทริบิวต์: ไม่มีใน: other',
    'integer'              => ':attribute ต้องเป็นจำนวนเต็มเท่านั้น',
    'ip'                   => ':attribute ต้องเป็นรูปแบบไอพีแอดเดรสเท่านั้น',
    'ipv4'                 => 'แอตทริบิวต์: ต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
    'ipv6'                 => 'แอตทริบิวต์: ต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
    'json'                 => 'แอตทริบิวต์: ต้องเป็นสตริง JSON ที่ถูกต้อง',
    'max'                  => [
        'numeric' => ':attribute ต้องไม่มากกว่า :max',
        'file'    => ':attribute ต้องไม่มีขนาดมากกว่า :max กิโลไบต์',
        'string'  => ':attribute ต้องไม่มีจำนวนตัวอักษรมากกว่า :max ตัวอักษร',
        'array'   => 'แอตทริบิวต์: ไม่สามารถมีได้มากกว่า: รายการสูงสุด',
    ],
    'mimes'                => ':attribute ต้องเป็นรูปแบบไฟล์ดังนี้: :values',
    'mimetypes'            => 'แอตทริบิวต์: ต้องเป็นไฟล์ประเภท:: values',
    'min'                  => [
        'numeric' => ':attribute ต้องมีอย่างน้อย :min',
        'file'    => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวนอย่างน้อย :min ตัวอักษร',
        'array'   => 'แอตทริบิวต์: ต้องมีอย่างน้อย: รายการต่ำสุด',
    ],
    'not_in'               => ':attribute ที่เลือกไม่ถูกต้อง',
    'numeric'              => ':attribute ต้องเป็นตัวเลขเท่านั้น',
    'present'              => 'ฟิลด์แอ็ตทริบิวต์: ต้องมีอยู่',
    'valid_regex'          => 'นั่นไม่ใช่ regex ที่ถูกต้อง ',
    'regex'                => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    'required'             => 'กรุณากรอกข้อมูลในฟิลด์ :attribute',
    'required_if'          => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :other เป็น :value',
    'required_unless'      => 'ฟิลด์แอ็ตทริบิวต์: ต้องใช้เว้นแต่กรณี: อื่น ๆ อยู่ใน: values',
    'required_with'        => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value มีข้อมูลอยู่ด้วย',
    'required_with_all'    => 'ฟิลด์แอ็ตทริบิวต์: ต้องระบุเมื่อ: มีค่าอยู่',
    'required_without'     => 'ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value ไม่มีข้อมูล',
    'required_without_all' => 'ฟิลด์แอ็ตทริบิวต์: ต้องระบุเมื่อไม่มี: มีค่าอยู่',
    'same'                 => ':attribute และ :other ต้องตรงกัน',
    'size'                 => [
        'numeric' => ':attribute ต้องมีขนาด :size',
        'file'    => ':attribute ต้องมีขนาด :size กิโลไบต์',
        'string'  => ':attribute ต้องมีจำนวน :size ตัวอักษร',
        'array'   => 'แอตทริบิวต์ต้องมี: รายการขนาด',
    ],
    'string'               => 'แอตทริบิวต์: ต้องเป็นสตริง',
    'timezone'             => 'แอตทริบิวต์: ต้องเป็นโซนที่ถูกต้อง',
    'unique'               => ':attribute กำลังใช้งานอยู่',
    'uploaded'             => 'แอตทริบิวต์: ล้มเหลวในการอัปโหลด',
    'url'                  => 'รูปแบบของ :attribute ไม่ถูกต้อง',
    "unique_undeleted"     => "แอตทริบิวต์ต้องไม่ซ้ำกัน",

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
        'alpha_space' => "ฟิลด์แอ็ตทริบิวต์: มีอักขระที่ไม่ได้รับอนุญาต",
        "email_array"      => "ที่อยู่อีเมลไม่ถูกต้อง",
        "hashed_pass"      => "รหัสผ่านปัจจุบันของคุณไม่ถูกต้อง",
        'dumbpwd'          => 'รหัสผ่านที่ใช้กันอยู่ทั่วไป',
        "statuslabel_type" => "คุณต้องเลือกประเภทป้ายสถานะที่ถูกต้อง",
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
