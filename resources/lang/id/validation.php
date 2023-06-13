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

    'accepted'             => ': Atribut harus diterima.',
    'active_url'           => ': Atribut ini URL-nya tidak valid.',
    'after'                => ': Atribut harus tanggal setelah: tanggal.',
    'after_or_equal'       => 'The: atribut harus tanggal setelah atau sama dengan: tanggal.',
    'alpha'                => ': Atribut hanya boleh berisi huruf.',
    'alpha_dash'           => ': Atribut hanya boleh berisi angka, huruf dan garis.',
    'alpha_num'            => ': Atribut hanya boleh berisi huruf dan angka.',
    'array'                => 'The: atribut harus berupa array.',
    'before'               => ': Atribut harus tanggal sebelum: tanggal.',
    'before_or_equal'      => 'The: atribut harus tanggal sebelum atau sama dengan: tanggal.',
    'between'              => [
        'numeric' => ': Atribut harus di antara: min -: maks.',
        'file'    => ': Atribut harus di antara: min -: maks kilobytes.',
        'string'  => ': Atribut harus di antara: min -: maks jumlah karakter.',
        'array'   => 'The: atribut harus antara: min dan: max item.',
    ],
    'boolean'              => 'Bidang atribut: harus benar atau salah.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => 'Tanggal :attribute tidak valid.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus dengan :digits digit.',
    'digits_between'       => 'Digit :attribute harus di antara :min dan :max.',
    'dimensions'           => 'Atribut: atribut memiliki dimensi gambar yang tidak benar.',
    'distinct'             => 'Bidang atribut: memiliki nilai duplikat.',
    'email'                => 'Format :attribute tidak benar.',
    'exists'               => ':attribute yang di pilih tidak benar.',
    'file'                 => 'The: atribut harus berupa file.',
    'filled'               => 'Bidang atribut: harus memiliki nilai.',
    'image'                => ':attribute harus dalam bentuk gambar.',
    'import_field_empty'    => 'The value for :fieldname cannot be null.',
    'in'                   => ':attribute yang di pilih tidak benar.',
    'in_array'             => 'Bidang atribut: tidak ada di: other.',
    'integer'              => ':attribute harus dalam bentuk integer.',
    'ip'                   => ':attribute harus memilik alamat IP yang benar.',
    'ipv4'                 => 'Atribut: harus alamat IPv4 yang valid.',
    'ipv6'                 => 'Atribut: harus alamat IPv6 yang valid.',
    'is_unique_department' => 'The :attribute must be unique to this Company Location',
    'json'                 => 'Atribut: harus string JSON yang valid.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => 'Atribut: mungkin tidak lebih dari: item maks.',
    ],
    'mimes'                => ':attribute harus memiliki tipe data :values.',
    'mimetypes'            => 'The: atribut harus berupa file tipe:: values.',
    'min'                  => [
        'numeric' => ':attribute seharusnya :min.',
        'file'    => ':attribute harus memiliki :min kilobyte.',
        'string'  => ':attribute harus memiliki :min jumlah karakter.',
        'array'   => 'Atribut: setidaknya harus memiliki: item min.',
    ],
    'starts_with'          => ':attribute harus dimulai dengan salah satu dari berikut ini: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => ':attribute yang di pilih tidak benar.',
    'numeric'              => ':attribute harus dalam angka.',
    'present'              => 'Bidang atribut: harus ada.',
    'valid_regex'          => 'Itu bukan regex yang valid. ',
    'regex'                => 'Format :attribute tidak benar.',
    'required'             => 'Kolom :attribute wajib di-isi.',
    'required_if'          => 'Kolom :attribute wajib di-isi ketika :other nya :value.',
    'required_unless'      => 'Bidang atribut: diperlukan kecuali: lainnya ada dalam: nilai.',
    'required_with'        => 'Kolom :attribute wajib di-isi ketika terdapat :values.',
    'required_with_all'    => 'Bidang atribut: diperlukan saat: nilai ada.',
    'required_without'     => 'Kolom :attribute wajib di-isi ketika :values tidak ada.',
    'required_without_all' => 'Bidang atribut: diperlukan bila tidak ada: nilai yang ada.',
    'same'                 => ':attribute dan :other harus cocok.',
    'size'                 => [
        'numeric' => 'Ukuran :attribute harus :size.',
        'file'    => ':attribute harus memiliki :size kilobyte.',
        'string'  => ':attribute harus memiliki :size karakter.',
        'array'   => 'Atribut: harus berisi: item ukuran.',
    ],
    'string'               => 'The: atribut harus berupa string.',
    'timezone'             => 'Atribut: harus merupakan zona yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => 'Atribut: gagal diupload.',
    'url'                  => 'Format :attribute tidak benar.',
    'unique_undeleted'     => ':attribute harus unik.',
    'non_circular'         => ':attribute tidak boleh membuat referensi melingkar.',
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

    'custom' => [
        'alpha_space' => 'Bidang atribut: berisi karakter yang tidak diizinkan.',
        'email_array'      => 'Satu atau lebih alamat email tidak valid.',
        'hashed_pass'      => 'Kata sandi Anda saat ini salah',
        'dumbpwd'          => 'Password itu terlalu umum',
        'statuslabel_type' => 'Anda harus memilih jenis label status yang valid',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => 'The :attribute must be a valid date in YYYY-MM-DD format',
        'last_audit_date.date_format'   =>  'The :attribute must be a valid date in YYYY-MM-DD hh:mm:ss format',
        'expiration_date.date_format'   =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'termination_date.date_format'  =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'expected_checkin.date_format'  =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'start_date.date_format'        =>  'The :attribute must be a valid date in YYYY-MM-DD format',
        'end_date.date_format'          =>  'The :attribute must be a valid date in YYYY-MM-DD format',

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
