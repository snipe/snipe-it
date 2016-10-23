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

    "accepted"         => ":attribute ต้องได้รับการยอมรับ",
    "active_url"       => ":attribute ไม่ใช่ URL ที่ถูกต้อง",
    "after"            => ":attribute ต้องเป็นวันที่หลังจาก :date",
    "alpha"            => ":attribute ต้องมีเฉพาะตัวอักษรเท่านั้น",
    "alpha_dash"       => ":attribute ต้องมีเฉพาะตัวอักษร ตัวเลข หรือเครื่องหมายลบเท่านั้น",
    "alpha_num"        => ":attribute ต้องมีเฉพาะตัวอักษรและตัวเลขเท่านั้น",
    "before"           => ":attribute ต้องเป็นวันที่ก่อน :date",
    "between"          => array(
        "numeric" => ":attribute ต้องอยู่ระหว่าง :min - :max",
        "file"    => ":attribute ต้องมีขนาดระหว่าง :min - :max กิโลไบต์",
        "string"  => ":attribute ต้องมีจำนวนระหว่าง :min - :max ตัวอักษร",
    ),
    "confirmed"        => ":attribute ไม่ตรงกัน",
    "date"             => ":attribute เป็นรูปแบบวันที่ที่ไม่ถูกต้อง",
    "date_format"      => ":attribute ไม่ตรงตามรูปแบบ :format",
    "different"        => ":attribute และ :other ต้องไม่เหมือนกัน",
    "digits"           => ":attribute ต้องเป็น :digits ตัวเลข",
    "digits_between"   => ":attribute ต้องเป็นตัวเลขระหว่าง :min และ :max",
    "email"            => "รูปแบบของ :attribute ไม่ถูกต้อง",
    "exists"           => ":attribute ที่เลือกไม่ถูกต้อง",
    "email_array"      => "One or more email addresses is invalid.",
    "image"            => ":attribute ต้องเป็นรูปภาพเท่านั้น",
    "in"               => ":attribute ที่เลือกไม่ถูกต้อง",
    "integer"          => ":attribute ต้องเป็นจำนวนเต็มเท่านั้น",
    "ip"               => ":attribute ต้องเป็นรูปแบบไอพีแอดเดรสเท่านั้น",
    "max"              => array(
        "numeric" => ":attribute ต้องไม่มากกว่า :max",
        "file"    => ":attribute ต้องไม่มีขนาดมากกว่า :max กิโลไบต์",
        "string"  => ":attribute ต้องไม่มีจำนวนตัวอักษรมากกว่า :max ตัวอักษร",
    ),
    "mimes"            => ":attribute ต้องเป็นรูปแบบไฟล์ดังนี้: :values",
    "min"              => array(
        "numeric" => ":attribute ต้องมีอย่างน้อย :min",
        "file"    => ":attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์",
        "string"  => ":attribute ต้องมีจำนวนอย่างน้อย :min ตัวอักษร",
    ),
    "not_in"           => ":attribute ที่เลือกไม่ถูกต้อง",
    "numeric"          => ":attribute ต้องเป็นตัวเลขเท่านั้น",
    "regex"            => "รูปแบบของ :attribute ไม่ถูกต้อง",
    "required"         => "กรุณากรอกข้อมูลในฟิลด์ :attribute",
    "required_if"      => "ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :other เป็น :value",
    "required_with"    => "ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value มีข้อมูลอยู่ด้วย",
    "required_without" => "ฟิลด์ :attribute จำเป็นต้องมีข้อมูล เมื่อ :value ไม่มีข้อมูล",
    "same"             => ":attribute และ :other ต้องตรงกัน",
    "size"             => array(
        "numeric" => ":attribute ต้องมีขนาด :size",
        "file"    => ":attribute ต้องมีขนาด :size กิโลไบต์",
        "string"  => ":attribute ต้องมีจำนวน :size ตัวอักษร",
    ),
    "unique"           => ":attribute กำลังใช้งานอยู่",
    "url"              => "รูปแบบของ :attribute ไม่ถูกต้อง",
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
    'alpha_space' => "ฟิลด์ :attribute ประกอบไปด้วยอักขระที่ไม่อนุญาต",

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
