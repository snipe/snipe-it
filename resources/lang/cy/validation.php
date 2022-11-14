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

    'accepted'             => 'Rhaid derbyn y :attribute.',
    'active_url'           => 'Nid ywr :attribute yn URL dilys.',
    'after'                => 'Rhaid i\'r :attribute bod yn dyddiad ar ol :date.',
    'after_or_equal'       => 'Rhaid i\'r :attribute bod yn dyddiad ar ol neu yn hafal i :date.',
    'alpha'                => 'Rhaid ir :attribute cynnwys llythrennau yn unig.',
    'alpha_dash'           => 'Fedrith y :attribute dim ond cynnwys llythrennau, rhifau a dashes.',
    'alpha_num'            => 'Rhaid ir :attribute cynnwys llythrennau a rhifau yn unig.',
    'array'                => 'Rhaid i :attribute fod yn array.',
    'before'               => 'Rhaid i\'r :attribute bod yn dyddiad cyn :date.',
    'before_or_equal'      => 'Rhaid i\'r :attribute bod yn dyddiad cyn neu yn hafal i :date.',
    'between'              => [
        'numeric' => 'Rhaid i\'r :attribute bod rhwng :min - :max.',
        'file'    => 'Rhaid i\'r :attribute bod rhwng :min - :max kilobytes.',
        'string'  => 'Rhaid i\'r :attribute bod rhwng :min - :max characters.',
        'array'   => 'Rhaid i\'r :attribute cael rhwng :min - :max o eitemau.',
    ],
    'boolean'              => 'Rhaid i :attribute fod yn wir neu ddim.',
    'confirmed'            => 'Dydi\'r cadarnhad :attribute ddim yn cydfynd.',
    'date'                 => 'Nid yw\'r :attribute yn dyddiad dilys.',
    'date_format'          => 'Nid yw\'r :attribute yn cydfynd ar format :format.',
    'different'            => 'Rhaid i :attribute a :other bod yn wahanol.',
    'digits'               => 'Rhai i\'r :attribute bod yn :digits o ddigidau.',
    'digits_between'       => 'Rhaid i\'r :attribute bodrhwng :min - :max o digidau.',
    'dimensions'           => 'Mae\'r :attribute hefo maint annilys.',
    'distinct'             => 'Mae\'r :attribute hefo maes sydd wedi\'i dyblygu.',
    'email'                => 'Mae fformat :attribute yn annilys.',
    'exists'               => 'Mae\'r :attribute a dewisir yn annilys.',
    'file'                 => 'Rhaid i\'r :attribute bod yn ffeil.',
    'filled'               => 'Rhaid i\'r maes :attribute cael gwerth.',
    'image'                => 'Rhaid i\'r :attribute bod yn delwedd.',
    'in'                   => 'Mae\'r :attribute a dewisir yn annilys.',
    'in_array'             => 'Nid yw\'r maes :attribute yn bodoli yn :other.',
    'integer'              => 'Rhaid i\'r :attribute bod yn cyfanrif.',
    'ip'                   => 'Rhaid i\'r :attribute bod yn cyfeiriad IP dilys.',
    'ipv4'                 => 'Rhaid i\'r :attribute bod yn cyfeiriad IPv4 dilys.',
    'ipv6'                 => 'Rhaid i\'r :attribute bod yn cyfeiriad IPv6 dilys.',
    'json'                 => 'Rhaid i\'r :attribute bod yn llinyn JSON dilys.',
    'max'                  => [
        'numeric' => 'Ni ellir :attribute bod yn fwy na :max.',
        'file'    => 'Ni ellir :attribute bod yn fwy na :max kilobytes.',
        'string'  => 'Ni ellir :attribute bod yn fwy na :max chaaracters.',
        'array'   => 'Ni ellir :attribute cael mwy na :max o eitemau.',
    ],
    'mimes'                => 'Rhaid i\'r :attribute bod yn ffeil o\'r math :values.',
    'mimetypes'            => 'Rhaid i\'r :attribute bod yn ffeil o\'r math: :values.',
    'min'                  => [
        'numeric' => 'Rhaid i\'r :attribute bod o leiaf :min.',
        'file'    => 'Rhaid i\'r :attribute bod o leiaf :min kilobytes.',
        'string'  => 'Rhaid i\'r :attribute bod o leiaf :min characters.',
        'array'   => 'Rhaid i\'r :attribute cael o leiaf :min o eitemau.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Mae\'r :attribute a dewisir yn annilys.',
    'numeric'              => 'Rhaid i\'r :attribute bod yn rhif.',
    'present'              => 'Rhaid i\'r maes :attribute bod yn presennol.',
    'valid_regex'          => 'Nid yw hyn yn Regex dilys. ',
    'regex'                => 'Mae\'r fformat :attribute yn annilys.',
    'required'             => 'Mae angen llenwi\'r maes :attribute.',
    'required_if'          => 'Mae angen y maes :attribute pan :other yw :value.',
    'required_unless'      => 'Mae angen y maes :attribute pan :other yn :values.',
    'required_with'        => 'Mae angen y maes :attribute pan mae :values yn bresennol.',
    'required_with_all'    => 'Mae angen y maes :attribute pan mae :values yn bresennol.',
    'required_without'     => 'Mae angen y maes :attribute os dydi\'r :values ddim yn bresennol.',
    'required_without_all' => 'Mae angen y maes :attribute os dydi\'r un o :values yn bresennol.',
    'same'                 => 'Rhaid i :attribute a :other cydfynd.',
    'size'                 => [
        'numeric' => 'Rhaid i\'r :attribute bod :size.',
        'file'    => 'Rhaid i\'r :attribute bod o leiaf :size kilobytes.',
        'string'  => 'Rhaid i\'r :attribute bod o leiaf :size characters.',
        'array'   => 'Rhaid ir :attribute cynnwys :size eitemau.',
    ],
    'string'               => 'Rhaid i\'r :attribute bod yn string.',
    'timezone'             => 'Rhaid i\'r :attribute bod yn barth dilys.',
    'unique'               => 'Mae\'r :attribute wedi cymeryd yn barod.',
    'uploaded'             => 'Mae\'r :attribute wedi fethu uwchlwytho.',
    'url'                  => 'Mae fformat :attribute yn annilys.',
    'unique_undeleted'     => 'Rhaid i\'r :attribute bod yn unigryw.',
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
        'alpha_space' => 'Mae\'r maes :attribute yn cynnwys cymeriad na chaniateir.',
        'email_array'      => 'Mae un neu fwy o gyfeiriadau e-bost yn annilys.',
        'hashed_pass'      => 'Mae eich cyfrinair cyfredol yn anghywir',
        'dumbpwd'          => 'Mae\'r cyfrinair hwnnw\'n rhy gyffredin.',
        'statuslabel_type' => 'Rhaid i chi ddewis math label statws dilys',
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
