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

    'accepted'             => ':attribute mesti diterima.',
    'active_url'           => ':attribute URL yang tidak sah.',
    'after'                => ':attribute mesti tarik selepas must :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandungi huruf, nombor dan tanda tolak.',
    'alpha_num'            => ':attribute hanya boleh mengadungi huruf dan nombor.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute mestilah tarikh sebelum :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute mesti berada diantara :min - :max.',
        'file'    => ':attribute mesti diantara :min - :max kilobytes.',
        'string'  => ':attribute mesti diantara :min - :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute pengesahan tidak sama.',
    'date'                 => ':attribute  tarikh yang tidak sah.',
    'date_format'          => ':attribute tidak mengikut format :format.',
    'different'            => ':attribute dan :other mesti berbeza.',
    'digits'               => ':attribute mesti :digits digit.',
    'digits_between'       => ':attribute mesti diantara :min and :max digit.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute format tidak sah.',
    'exists'               => 'Piliah :attribute tidak sah.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute mesti imej.',
    'in'                   => 'Piliah :attribute tidak sah.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute mesti integer.',
    'ip'                   => ':attribute mesti alamat IP yang sah.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobytes.',
        'string'  => ':attribute tidak boleh lebih besar dari :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute mesti fail jenis: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute mesti sekurang2nya :min.',
        'file'    => ':attribute mesti sekurang2nya :min kilobytes.',
        'string'  => ':attribute mesti sekurang2nya :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Piliah :attribute tidak sah.',
    'numeric'              => ':attribute mesti nombor.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute format tidak sah.',
    'required'             => ':attribute ruangan diperlukan.',
    'required_if'          => ':attribute rungan diperlukan bila :other adalah :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute ruangan diperlukan bila :values wujud.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute ruangan diperlukan bila :values tidak wujud.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute dan :other mesti sama.',
    'size'                 => [
        'numeric' => ':attribute mesti :size.',
        'file'    => ':attribute mesti :size kilobytes.',
        'string'  => ':attribute mesti :size aksara.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute telah diambil.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute format tidak sah.',

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
