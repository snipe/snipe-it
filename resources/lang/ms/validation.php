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

    'accepted'             => ':attribute mesti diterima.',
    'active_url'           => ':attribute URL yang tidak sah.',
    'after'                => ':attribute mesti tarik selepas must :date.',
    'after_or_equal'       => 'The: atribut mestilah tarikh selepas atau sama dengan: tarikh.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandungi huruf, nombor dan tanda tolak.',
    'alpha_num'            => ':attribute hanya boleh mengadungi huruf dan nombor.',
    'array'                => 'The: attribute must be array.',
    'before'               => ':attribute mestilah tarikh sebelum :date.',
    'before_or_equal'      => 'The: atribut mestilah tarikh sebelum atau sama dengan: tarikh.',
    'between'              => [
        'numeric' => ':attribute mesti berada diantara :min - :max.',
        'file'    => ':attribute mesti diantara :min - :max kilobytes.',
        'string'  => ':attribute mesti diantara :min - :max characters.',
        'array'   => 'The: attribute must have between: min and: max items.',
    ],
    'boolean'              => ': Bidang atribut mestilah benar atau palsu.',
    'confirmed'            => ':attribute pengesahan tidak sama.',
    'date'                 => ':attribute  tarikh yang tidak sah.',
    'date_format'          => ':attribute tidak mengikut format :format.',
    'different'            => ':attribute dan :other mesti berbeza.',
    'digits'               => ':attribute mesti :digits digit.',
    'digits_between'       => ':attribute mesti diantara :min and :max digit.',
    'dimensions'           => 'The: attribute mempunyai dimensi imej tidak sah.',
    'distinct'             => 'The: bidang atribut mempunyai nilai pendua.',
    'email'                => ':attribute format tidak sah.',
    'exists'               => 'Piliah :attribute tidak sah.',
    'file'                 => 'The: attribute must be a file.',
    'filled'               => ': Bidang atribut mesti mempunyai nilai.',
    'image'                => ':attribute mesti imej.',
    'in'                   => 'Piliah :attribute tidak sah.',
    'in_array'             => 'The: bidang atribut tidak wujud di: lain.',
    'integer'              => ':attribute mesti integer.',
    'ip'                   => ':attribute mesti alamat IP yang sah.',
    'ipv4'                 => 'The: attribute mestilah alamat IPv4 yang sah.',
    'ipv6'                 => 'The: atribut mestilah alamat IPv6 yang sah.',
    'json'                 => 'The: attribute mestilah rentetan JSON yang sah.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobytes.',
        'string'  => ':attribute tidak boleh lebih besar dari :max characters.',
        'array'   => 'The: attribute mungkin tidak mempunyai lebih daripada: item maks.',
    ],
    'mimes'                => ':attribute mesti fail jenis: :values.',
    'mimetypes'            => 'The: attribute mestilah file jenis:: nilai.',
    'min'                  => [
        'numeric' => ':attribute mesti sekurang2nya :min.',
        'file'    => ':attribute mesti sekurang2nya :min kilobytes.',
        'string'  => ':attribute mesti sekurang2nya :min characters.',
        'array'   => 'The: atribut mesti mempunyai sekurang-kurangnya: item min.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Piliah :attribute tidak sah.',
    'numeric'              => ':attribute mesti nombor.',
    'present'              => 'Yang: bidang atribut mesti ada.',
    'valid_regex'          => 'Itu bukan regex yang sah. ',
    'regex'                => ':attribute format tidak sah.',
    'required'             => ':attribute ruangan diperlukan.',
    'required_if'          => ':attribute rungan diperlukan bila :other adalah :value.',
    'required_unless'      => 'Bidang: atribut diperlukan kecuali: yang lain berada dalam: nilai.',
    'required_with'        => ':attribute ruangan diperlukan bila :values wujud.',
    'required_with_all'    => 'Bidang: sifat diperlukan apabila: nilai hadir.',
    'required_without'     => ':attribute ruangan diperlukan bila :values tidak wujud.',
    'required_without_all' => 'The: field attribute diperlukan apabila tidak ada: nilai hadir.',
    'same'                 => ':attribute dan :other mesti sama.',
    'size'                 => [
        'numeric' => ':attribute mesti :size.',
        'file'    => ':attribute mesti :size kilobytes.',
        'string'  => ':attribute mesti :size aksara.',
        'array'   => 'The: attribute mesti mengandungi: item saiz.',
    ],
    'string'               => 'The: attribute must be string.',
    'timezone'             => 'The: attribute mesti zon yang sah.',
    'unique'               => ':attribute telah diambil.',
    'uploaded'             => 'The: attribute gagal untuk dimuat naik.',
    'url'                  => ':attribute format tidak sah.',
    'unique_undeleted'     => ':attribute mesti unik.',
    'non_circular'         => 'The :attribute must not create a circular reference.',
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
        'alpha_space' => 'Bidang: atribut mengandungi aksara yang tidak dibenarkan.',
        'email_array'      => 'Satu atau lebih alamat e-mel tidak sah.',
        'hashed_pass'      => 'Kata laluan semasa anda tidak betul',
        'dumbpwd'          => 'Kata laluan itu terlalu umum.',
        'statuslabel_type' => 'Anda mesti memilih jenis label status yang sah',
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
