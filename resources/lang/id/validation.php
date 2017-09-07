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

    'accepted'             => ': Atribut harus diterima.',
    'active_url'           => ': Atribut ini URL-nya tidak valid.',
    'after'                => ': Atribut harus tanggal setelah: tanggal.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ': Atribut hanya boleh berisi huruf.',
    'alpha_dash'           => ': Atribut hanya boleh berisi angka, huruf dan garis.',
    'alpha_num'            => ': Atribut hanya boleh berisi huruf dan angka.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ': Atribut harus tanggal sebelum: tanggal.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ': Atribut harus di antara: min -: maks.',
        'file'    => ': Atribut harus di antara: min -: maks kilobytes.',
        'string'  => ': Atribut harus di antara: min -: maks jumlah karakter.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => 'Tanggal :attribute tidak valid.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus dengan :digits digit.',
    'digits_between'       => 'Digit :attribute harus di antara :min dan :max.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Format :attribute tidak benar.',
    'exists'               => ':attribute yang di pilih tidak benar.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute harus dalam bentuk gambar.',
    'in'                   => ':attribute yang di pilih tidak benar.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute harus dalam bentuk integer.',
    'ip'                   => ':attribute harus memilik alamat IP yang benar.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute harus memiliki tipe data :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute seharusnya :min.',
        'file'    => ':attribute harus memiliki :min kilobyte.',
        'string'  => ':attribute harus memiliki :min jumlah karakter.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute yang di pilih tidak benar.',
    'numeric'              => ':attribute harus dalam angka.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Format :attribute tidak benar.',
    'required'             => 'Kolom :attribute wajib di-isi.',
    'required_if'          => 'Kolom :attribute wajib di-isi ketika :other nya :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Kolom :attribute wajib di-isi ketika terdapat :values.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Kolom :attribute wajib di-isi ketika :values tidak ada.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute dan :other harus cocok.',
    'size'                 => [
        'numeric' => 'Ukuran :attribute harus :size.',
        'file'    => ':attribute harus memiliki :size kilobyte.',
        'string'  => ':attribute harus memiliki :size karakter.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Format :attribute tidak benar.',

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
