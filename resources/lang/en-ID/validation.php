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
    'in'                   => 'Yang dipilih :atribut tidak valid.',
    'in_array'             => 'Bidang atribut :tidak ada di :lainnya.',
    'integer'              => 'Atribut harus integer.',
    'ip'                   => 'Atribut :harus alamat IP yang valid.',
    'ipv4'                 => 'Atribut :harus alamat IPv4 yang valid.',
    'ipv6'                 => 'Atribut :harus alamat IPv6 yang valid.',
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
    'not_in'               => 'Yang dipilih: atribut tidak valid.',
    'numeric'              => 'The: atribut harus berupa angka.',
    'present'              => 'Bidang atribut harus ada.',
    'valid_regex'          => 'Ini bukan regex yang valid. ',
    'regex'                => 'Format atribut tidak valid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
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
        'alpha_space' => "The :attribute field contains a character that is not allowed.",
        "email_array"      => "Satu atau lebih alamat surel tidak valid.",
        "hashed_pass"      => "Kata sandi anda saat ini salah",
        'dumbpwd'          => 'Kata sandi itu terlalu umum.',
        "statuslabel_type" => "Anda harus pilih jenis label status yang valid",
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
