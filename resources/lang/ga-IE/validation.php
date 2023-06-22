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

    'accepted'             => 'Ní mór glacadh leis an tréith.',
    'active_url'           => 'Níl an tréith: URL bailí.',
    'after'                => 'An: Ní mór tréith a bheith ina dháta tar éis: dáta.',
    'after_or_equal'       => 'An: Ní mór tréith a bheith ina dáta tar éis nó cothrom leis: dáta.',
    'alpha'                => 'Ní fhéadfar ach litreacha a bheith i dtréith.',
    'alpha_dash'           => 'Ní féidir leis an tréith: litreacha, uimhreacha, agus taiscí a bheith ann.',
    'alpha_num'            => 'Ní fhéadfar ach litreacha agus uimhreacha a bheith i dtréith.',
    'array'                => 'An: Ní mór tréith a bheith ina sraith.',
    'before'               => 'An: Ní mór tréith a bheith ina dháta roimh: dáta.',
    'before_or_equal'      => 'An: Ní mór tréith a bheith ina dháta roimh nó cothrom le: dáta.',
    'between'              => [
        'numeric' => 'An: Ní mór tréith a bheith idir: min agus: max.',
        'file'    => 'An: Ní mór tréith a bheith idir: min agus: max kilobytes.',
        'string'  => 'An: Ní mór tréith a bheith idir: min agus: carachtair uasta.',
        'array'   => 'An: Ní mór go mbeadh idir tréith: min agus: míreanna is mó.',
    ],
    'boolean'              => 'Ní mór an réimse tréith a bheith fíor nó bréagach.',
    'confirmed'            => 'Ní dhéanann an daingniú tréith comhoiriúnach leis.',
    'date'                 => 'Níl an tréith: dáta bailí.',
    'date_format'          => 'An: ní bhaineann an tréith leis an bhformáid: formáid.',
    'different'            => 'An: tréith agus: ní mór eile a bheith difriúil.',
    'digits'               => 'An: Ní mór tréith a bheith: dhigit dhigit.',
    'digits_between'       => 'An: Ní mór tréith a bheith idir: min agus: uimhreacha móra.',
    'dimensions'           => 'Tá: toisí íomhá neamhbhailí ag tréith.',
    'distinct'             => 'Tá: luach dúblach ag an réimse tréith.',
    'email'                => 'An: Ní mór don tréith a bheith ina seoladh ríomhphoist bailí.',
    'exists'               => 'An roghnaithe: tá tréith neamhbhailí.',
    'file'                 => 'An: Ní mór tréith a bheith ina chomhad.',
    'filled'               => 'Ní mór go mbeadh luach ag an réimse tréith.',
    'image'                => 'An: Ní mór tréith a bheith ina íomhá.',
    'import_field_empty'    => 'The value for :fieldname cannot be null.',
    'in'                   => 'An roghnaithe: tá tréith neamhbhailí.',
    'in_array'             => 'Níl an: réimse tréith i: eile.',
    'integer'              => 'An: Ní mór tréith a bheith ina slánuimhir.',
    'ip'                   => 'Ní mór an tréith: seoladh IP bailí a bheith ann.',
    'ipv4'                 => 'Ní mór don ghné seo: seoladh IPv4 bailí.',
    'ipv6'                 => 'Ní mór don ghné seo: seoladh IPv6 bailí.',
    'is_unique_department' => 'The :attribute must be unique to this Company Location',
    'json'                 => 'An: ní mór gur tréith JSON bailí í an tréith.',
    'max'                  => [
        'numeric' => 'An: ní fhéadfar tréith a bheith níos mó ná: max.',
        'file'    => 'An: Ní fhéadfadh tréith níos mó ná: max kilobytes.',
        'string'  => 'An: Ní fhéadfar tréith a bheith níos mó ná: carachtair uasta.',
        'array'   => 'An: Ní fhéadfadh go mbeadh níos mó ná tréith: míreanna is mó.',
    ],
    'mimes'                => 'An: Ní mór tréith a bheith ina chomhad den chineál:: luachanna.',
    'mimetypes'            => 'An: Ní mór tréith a bheith ina chomhad den chineál:: luachanna.',
    'min'                  => [
        'numeric' => 'Ní mór: tréith a bheith ar a laghad: min.',
        'file'    => 'Ní mór: tréith a bheith ar a laghad: kilobyte min.',
        'string'  => 'Ní mór: tréith a bheith ar a laghad: carachtair min.',
        'array'   => 'Ní mór go mbeadh míreanna min ar a laghad ag an tréith.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'ends_with'            => 'The :attribute must end with one of the following: :values.',

    'not_in'               => 'An roghnaithe: tá tréith neamhbhailí.',
    'numeric'              => 'An: Ní mór tréith a bheith ina líon.',
    'present'              => 'Ní mór an réimse tréith a bheith i láthair.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Tá an fhormáid tréithbhail neamhbhailí.',
    'required'             => 'An: Tá réimse tréith ag teastáil.',
    'required_if'          => 'An: Tá réimse tréith ag teastáil nuair: eile é: luach.',
    'required_unless'      => 'An: Tá réimse tréith de dhíth mura bhfuil: eile i: luachanna.',
    'required_with'        => 'An: Tá réimse tréith ag teastáil nuair a bhíonn: luachanna i láthair.',
    'required_with_all'    => 'An: Tá réimse tréith ag teastáil nuair a bhíonn: luachanna i láthair.',
    'required_without'     => 'An: Tá réimse tréith ag teastáil nuair nach bhfuil luachanna i láthair.',
    'required_without_all' => 'An: Tá réimse tréith ag teastáil nuair nach bhfuil aon cheann de na luachanna i láthair.',
    'same'                 => 'An: tréith agus: ní mór eile a mheaitseáil.',
    'size'                 => [
        'numeric' => 'An: Ní mór tréith a bheith: méid.',
        'file'    => 'An: Ní mór tréith a bheith: kilobytes méid.',
        'string'  => 'An: Ní mór tréith a bheith: carachtair mhéid.',
        'array'   => 'Ní mór go mbeadh na nithe seo a leanas i dtréith: míreanna méide.',
    ],
    'string'               => 'An: Ní mór tréith a bheith ina teaghrán.',
    'timezone'             => 'An: Ní mór go mbeadh tréith ina chrios bailí.',
    'unique'               => 'An: tá tréith déanta cheana féin.',
    'uploaded'             => 'The: theip ar an tréith a uaslódáil.',
    'url'                  => 'Tá an fhormáid tréithbhail neamhbhailí.',
    'unique_undeleted'     => 'The :attribute must be unique.',
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
        'alpha_space' => 'An: sa réimse tréith tá carachtar nach bhfuil ceadaithe.',
        'email_array'      => 'Tá seoltaí ríomhphoist amháin nó níos mó neamhbhailí.',
        'hashed_pass'      => 'Tá do phasfhocal reatha mícheart',
        'dumbpwd'          => 'Tá an focal faire sin ró-choitianta.',
        'statuslabel_type' => 'Ní mór duit cineál lipéad stádas bailí a roghnú',

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
