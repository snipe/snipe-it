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

    'accepted'             => 'Atribut :harus diterima.',
    'active_url'           => 'Atribut :bukan URL yang valid.',
    'after'                => 'Atribut :harus tanggal setelah: tanggal.',
    'after_or_equal'       => 'Atribut :harus tanggal setelah atau sama dengan: tanggal.',
    'alpha'                => 'Atribut :hanya boleh berisi huruf.',
    'alpha_dash'           => 'Atribut :hanya boleh berisi huruf, angka, dan tanda hubung.',
    'alpha_num'            => 'Atribut :hanya boleh berisi huruf dan angka.',
    'array'                => 'Atribut :harus berupa array.',
    'before'               => 'Atribut :harus tanggal setelah: tanggal.',
    'before_or_equal'      => 'Atribut :harus tanggal setelah atau sama dengan: tanggal.',
    'between'              => [
        'numeric' => 'Atribut harus antara :min - : max.',
        'file'    => 'Atribut harus antara :min - : max.',
        'string'  => 'Atribut harus antara :min - : maks karakter.',
        'array'   => 'Atribut :harus antara :min dan : max item.',
    ],
    'boolean'              => 'Atribut: harus benar atau salah.',
    'confirmed'            => 'The: konfirmasi atribut tidak cocok.',
    'date'                 => 'Atribut :bukan Tanggal yang valid.',
    'date_format'          => 'The: atribut tidak sesuai format: format.',
    'different'            => 'The: atribut dan: lainnya harus berbeda.',
    'digits'               => 'Atribut: harus: digit digit.',
    'digits_between'       => 'Atribut :harus antara :min dan : max digit.',
    'dimensions'           => 'Atribut: atribut memiliki dimensi gambar yang tidak benar.',
    'distinct'             => 'The :Bidang atribut memiliki nilai duplikat.',
    'email'                => 'Format atribut tidak valid.',
    'exists'               => 'Yang dipilih: atribut tidak valid.',
    'file'                 => 'The: atribut harus berupa file.',
    'filled'               => 'Bidang atribut harus memiliki nilai.',
    'image'                => 'Atribut: harus berupa gambar.',
    'import_field_empty'    => 'The value for :fieldname cannot be null.',
    'in'                   => 'Yang dipilih :atribut tidak valid.',
    'in_array'             => 'Bidang atribut :tidak ada di :lainnya.',
    'integer'              => 'Atribut harus integer.',
    'ip'                   => 'Atribut :harus alamat IP yang valid.',
    'ipv4'                 => 'Atribut :harus alamat IPv4 yang valid.',
    'ipv6'                 => 'Atribut :harus alamat IPv6 yang valid.',
    'is_unique_department' => 'The :attribute must be unique to this Company Location',
    'json'                 => 'Atribut: harus string JSON yang valid.',
    'max'                  => [
        'numeric' => 'Atribut: mungkin tidak lebih besar dari: maks.',
        'file'    => 'Atribut :mungkin tidak lebih besar dari :max kilobyte.',
        'string'  => 'Atribut :mungkin tidak lebih besar dari :karakter maks.',
        'array'   => 'Atribut :mungkin tidak lebih dari :item maks.',
    ],
    'mimes'                => 'Atribut harus berupa file tipe: :niai.',
    'mimetypes'            => 'Atribut harus berupa file tipe: : nilai.',
    'min'                  => [
        'numeric' => 'Atribut :minimal harus :min.',
        'file'    => 'Atribut :minimal harus :min kilobyte.',
        'string'  => 'Atribut :minimal harus :min karakter.',
        'array'   => 'Atribut :setidaknya harus memiliki :item min.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => 'Yang dipilih: atribut tidak valid.',
    'numeric'              => 'The: atribut harus berupa angka.',
    'present'              => 'Bidang atribut harus ada.',
    'valid_regex'          => 'Ini bukan regex yang valid. ',
    'regex'                => 'Format atribut tidak valid.',
    'required'             => 'Bidang :attribute harus diisi.',
    'required_if'          => 'Kolom :attribute wajib di-isi ketika :other nya :value.',
    'required_unless'      => 'Kolom :attribute wajib di-isi kecuali :other nya :value.',
    'required_with'        => 'Kolom :attribute wajib di-isi ketika :values terisi.',
    'required_with_all'    => 'Kolom :attribute wajib di-isi ketika :values terisi.',
    'required_without'     => 'Kolom :attribute wajib di-isi ketika :values kosong.',
    'required_without_all' => 'Kolom :attribute wajib di-isi jika tidak ada :values yang terisi.',
    'same'                 => ':attribute dan :other harus mirip.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus berukuran :size kilobytes.',
        'string'  => ':attribute harus memiliki :size karakter.',
        'array'   => ':attribute harus memiliki sebanyak :size item.',
    ],
    'string'               => ':attribute haruslah sebuah string.',
    'timezone'             => ':attribute haruslah sebuah zone yang valid.',
    'unique'               => ':attribute sudah pernah digunakan.',
    'uploaded'             => ':attribute gagal di-upload.',
    'url'                  => 'Format :attribute tidaklah benar.',
    'unique_undeleted'     => ':attribute haruslah unik.',
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

    'custom' => [
        'alpha_space' => 'Kolom :attribute mengandung karakter yang dilarang.',
        'email_array'      => 'Satu atau lebih alamat surel tidak valid.',
        'hashed_pass'      => 'Kata sandi anda saat ini salah',
        'dumbpwd'          => 'Kata sandi itu terlalu umum.',
        'statuslabel_type' => 'Anda harus pilih jenis label status yang valid',

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
