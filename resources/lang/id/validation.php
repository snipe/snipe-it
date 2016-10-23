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

    "accepted"         => ": Atribut harus diterima.",
    "active_url"       => ": Atribut ini URL-nya tidak valid.",
    "after"            => ": Atribut harus tanggal setelah: tanggal.",
    "alpha"            => ": Atribut hanya boleh berisi huruf.",
    "alpha_dash"       => ": Atribut hanya boleh berisi angka, huruf dan garis.",
    "alpha_num"        => ": Atribut hanya boleh berisi huruf dan angka.",
    "before"           => ": Atribut harus tanggal sebelum: tanggal.",
    "between"          => array(
        "numeric" => ": Atribut harus di antara: min -: maks.",
        "file"    => ": Atribut harus di antara: min -: maks kilobytes.",
        "string"  => ": Atribut harus di antara: min -: maks jumlah karakter.",
    ),
    "confirmed"        => "Konfirmasi :attribute tidak cocok.",
    "date"             => "Tanggal :attribute tidak valid.",
    "date_format"      => ":attribute tidak cocok dengan format :format.",
    "different"        => ":attribute dan :other harus berbeda.",
    "digits"           => ":attribute harus dengan :digits digit.",
    "digits_between"   => "Digit :attribute harus di antara :min dan :max.",
    "email"            => "Format :attribute tidak benar.",
    "exists"           => ":attribute yang di pilih tidak benar.",
    "email_array"      => "Satu atau lebih alamat email tidak benar.",
    "image"            => ":attribute harus dalam bentuk gambar.",
    "in"               => ":attribute yang di pilih tidak benar.",
    "integer"          => ":attribute harus dalam bentuk integer.",
    "ip"               => ":attribute harus memilik alamat IP yang benar.",
    "max"              => array(
        "numeric" => ":attribute tidak boleh lebih dari :max.",
        "file"    => ":attribute tidak boleh lebih dari :max kilobyte.",
        "string"  => ":attribute tidak boleh lebih dari :max karakter.",
    ),
    "mimes"            => ":attribute harus memiliki tipe data :values.",
    "min"              => array(
        "numeric" => ":attribute seharusnya :min.",
        "file"    => ":attribute harus memiliki :min kilobyte.",
        "string"  => ":attribute harus memiliki :min jumlah karakter.",
    ),
    "not_in"           => ":attribute yang di pilih tidak benar.",
    "numeric"          => ":attribute harus dalam angka.",
    "regex"            => "Format :attribute tidak benar.",
    "required"         => "Kolom :attribute wajib di-isi.",
    "required_if"      => "Kolom :attribute wajib di-isi ketika :other nya :value.",
    "required_with"    => "Kolom :attribute wajib di-isi ketika terdapat :values.",
    "required_without" => "Kolom :attribute wajib di-isi ketika :values tidak ada.",
    "same"             => ":attribute dan :other harus cocok.",
    "size"             => array(
        "numeric" => "Ukuran :attribute harus :size.",
        "file"    => ":attribute harus memiliki :size kilobyte.",
        "string"  => ":attribute harus memiliki :size karakter.",
    ),
    "unique"           => ":attribute sudah digunakan.",
    "url"              => "Format :attribute tidak benar.",
    "statuslabel_type" => "Anda harus memilih tipe status label yang benar",
    "unique_undeleted" => ":attribute harus unik.",


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
    'alpha_space' => "Kolom :attribute tidak boleh di isi karakter yang tidak di perbolehkan.",

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
