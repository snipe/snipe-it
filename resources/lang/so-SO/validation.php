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

    'accepted'             => ' :attribute waa in la aqbalaa',
    'active_url'           => ' :attribute ku maaha URL sax ah.',
    'after'                => ' :attribute ku waa inuu noqdaa taariikh ka dambaysa :date.',
    'after_or_equal'       => ' :attribute ku waa inuu noqdaa taariikh ka dambaysa ama la mid ah :date.',
    'alpha'                => ' :attribute waxa ku jiri kara xarfo kaliya',
    'alpha_dash'           => ' :attribute ku waxa uu ka koobnaan karaa xarfo, tirooyin, iyo jajab.',
    'alpha_num'            => ' :attribute ku waxa uu ka koobnaan karaa xarfo iyo tirooyin keliya.',
    'array'                => ' :attribute ku waa inuu noqdaa hannaan',
    'before'               => ' :attribute ku waa inuu ahaadaa taariikh ka horeysa :date.',
    'before_or_equal'      => ' :attribute ku waa inuu ahaadaa taariikh ka horeysa ama la mid ah :date.',
    'between'              => [
        'numeric' => ' :attribute ku waa inuu u dhexeeyaa :min - :max.',
        'file'    => ' :attribute ku waa inuu u dhexeeyaa :min - :max kilobytes.',
        'string'  => ' :attribute ku waa inuu u dhexeeyaa :min - :max xaraf.',
        'array'   => ' :attribute ku waa inuu lahaadaa inta u dhaxaysa :min iyo :max shay.',
    ],
    'boolean'              => ' :attribute ku waa inuu run yahay ama been yahay.',
    'confirmed'            => 'Xaqiijinta :attribute kuma habboona',
    'date'                 => ' :attribute maaha taariikh ansax ah.',
    'date_format'          => ' :attribute ku kuma habboona qaabka :format.',
    'different'            => ' :attribute iyo :other waa inay kala duwanaadaan.',
    'digits'               => ' :attribute ku waa inuu noqdaa :digits lambar',
    'digits_between'       => ' :attribute ku waa inuu u dhexeeyaa :min iyo :max lambar',
    'dimensions'           => ' :attribute ku wuxuu leeyahay cabbir sawireed aan sax ahayn.',
    'distinct'             => 'Goobta :attribute waxay leedahay qiime nuqul ah',
    'email'                => 'Qaabka :attribute waa mid aan sax ahayn',
    'exists'               => 'Xulashada :attribute waa mid aan sax ahayn.',
    'file'                 => ' :attribute ku waa inuu noqdaa fayl',
    'filled'               => 'Goobta :attribute waa in ay leedahay qiimo.',
    'image'                => ' :attribute ku waa inuu noqdaa sawir',
    'import_field_empty'    => 'Qiimaha :fieldname ma noqon karo waxba.',
    'in'                   => 'Xulashada :attribute waa mid aan sax ahayn.',
    'in_array'             => 'Goobta :attribute kuma jirto gudaha :other.',
    'integer'              => ' :attribute ku waa inuu noqdaa tiro',
    'ip'                   => ' :attribute ku waa inuu noqdaa ciwaanka IP sax ah',
    'ipv4'                 => ' :attribute ku waa inuu noqdaa ciwaanka IPv4 ansax ah.',
    'ipv6'                 => ' :attribute ku waa inuu noqdaa ciwaanka IPv6 ansax ah.',
    'is_unique_department' => ' :attribute ku waa inuu noqdaa mid u gaar ah Goobta Shirkadda',
    'json'                 => ' :attribute ku waa inuu noqdaa xadhig JSON sax ah.',
    'max'                  => [
        'numeric' => ' :attribute waxaa laga yaabaa inuusan ka weyneyn :max.',
        'file'    => ' :attribute waxa laga yaabaa in aanu ka badnayn :max kilobytes.',
        'string'  => ' :attribute waxa laga yaabaa in aanu ka badnayn :max xaraf',
        'array'   => ' :attribute waxa laga yaabaa in aanu ka badnayn :max shay.',
    ],
    'mimes'                => ' :attribute ku waa inuu noqdaa fayl nooca: :values.',
    'mimetypes'            => ' :attribute ku waa inuu noqdaa fayl nooca: :values.',
    'min'                  => [
        'numeric' => ' :attribute ku waa inuu ahaadaa ugu yaraan :min.',
        'file'    => ' :attribute ku waa inuu ahaadaa ugu yaraan :min kilobytes.',
        'string'  => ' :attribute ku waa inuu noqdaa ugu yaraan :min xaraf',
        'array'   => ' :attribute ku waa inuu lahaadaa ugu yaraan :min walxood.',
    ],
    'starts_with'          => ' :attribute ku waa inuu ku bilaabmaa mid ka mid ah kuwan soo socda: :values.',
    'ends_with'            => ' :attribute ku waa inuu ku dhamaadaa mid ka mid ah kuwan soo socda: :values.',

    'not_in'               => 'Xulashada :attribute waa mid aan sax ahayn.',
    'numeric'              => ' :attribute ku waa inuu noqdaa tiro',
    'present'              => 'Goobta :attribute waa inay jirtaa',
    'valid_regex'          => 'Taasi ma aha regex sax ah. ',
    'regex'                => 'Qaabka :attribute waa mid aan sax ahayn',
    'required'             => 'Goobta :attribute waa loo baahan yahay',
    'required_if'          => 'Goobta :attribute ayaa loo baahan yahay marka :other uu yahay :value.',
    'required_unless'      => 'Goobta :attribute waa loo baahan yahay ilaa :other ku jiro :values.',
    'required_with'        => 'Goobta :attribute ayaa loo baahan yahay marka :values uu joogo.',
    'required_with_all'    => 'Goobta :attribute ayaa loo baahan yahay marka :values uu joogo.',
    'required_without'     => 'Goobta :attribute ayaa loo baahan yahay marka :values aanu joogin.',
    'required_without_all' => 'Goobta :attribute ayaa loo baahan yahay marka midna :values aanu joogin.',
    'same'                 => ' :attribute iyo :other waa inay iswaafaqaan',
    'size'                 => [
        'numeric' => ' :attribute ku waa inuu ahaadaa :size.',
        'file'    => ' :attribute ku waa inuu ahaadaa :size kilobytes.',
        'string'  => ' :attribute ku waa inuu noqdaa :size xaraf',
        'array'   => ' :attribute ku waa inuu ka kooban yahay :size walxood.',
    ],
    'string'               => ' :attribute ku waa inuu noqdaa xadhig',
    'timezone'             => ' :attribute ku waa inuu noqdaa aag ansax ah.',
    'two_column_unique_undeleted' => 'The :attribute must be unique across :table1 and :table2. ',
    'unique'               => ' :attribute waa la qaatay mar hore',
    'uploaded'             => ' :attribute ku wuu ku guul daraystay inuu soo geliyo',
    'url'                  => 'Qaabka :attribute waa mid aan sax ahayn',
    'unique_undeleted'     => ' :attribute ku waa inuu noqdaa mid gaar ah',
    'non_circular'         => ' :attribute waa inaanu samayn tixraac wareeg ah.',
    'not_array'            => ':attribute cannot be an array.',
    'disallow_same_pwd_as_user_fields' => 'Password ma la mid noqon karo magaca isticmaalaha',
    'letters'              => 'Furaha waa in uu ka kooban yahay ugu yaraan hal xaraf.',
    'numbers'              => 'Furaha waa in uu ka kooban yahay ugu yaraan hal lambar.',
    'case_diff'            => 'Furaha waa in uu isticmaalo kiis isku dhafan.',
    'symbols'              => 'Erayga sirta ah waa inuu ka kooban yahay calaamado.',
    'gte'                  => [
        'numeric'          => 'Qiimuhu ma noqon karo mid xun'
    ],
    'checkboxes'           => ':attribute contains invalid options.',
    'radio_buttons'        => ':attribute is invalid.',


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
        'alpha_space' => 'Goobta :attribute waxay ka kooban tahay xarfo aan la oggolayn.',
        'email_array'      => 'Hal ama ka badan ciwaanka iimaylka waa mid aan shaqayn.',
        'hashed_pass'      => 'Eraygaaga hadda jira waa khalad',
        'dumbpwd'          => 'Furahaas aad buu u badan yahay.',
        'statuslabel_type' => 'Waa inaad doorataa nooca summada heerka ansax ah',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',
        'last_audit_date.date_format'   =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD hh:mm:ss ',
        'expiration_date.date_format'   =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',
        'termination_date.date_format'  =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',
        'expected_checkin.date_format'  =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',
        'start_date.date_format'        =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',
        'end_date.date_format'          =>  ' :attribute ku waa inuu ahaado taariikh ansax ah oo qaabaysan YYY-MM-DD',

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

    /*
    |--------------------------------------------------------------------------
    | Generic Validation Messages
    |--------------------------------------------------------------------------
    */
    'invalid_value_in_field' => 'Invalid value included in this field',
];
