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

    'accepted'             => ':attribute turi būti patvirtintas.',
    'active_url'           => ':attribute nėra tinkamas interentinis puslapis.',
    'after'                => ':attribute privalo būti data po :date.',
    'after_or_equal'       => ':attribute privalo būti data lygi arba vėlesnė negu :date.',
    'alpha'                => ':attribute gali būti tik raidės.',
    'alpha_dash'           => ':attribute gali būti tik raidės, skaičiai ir brūkšneliai.',
    'alpha_num'            => ':attribute gali būti tik raidės ir skaičiai.',
    'array'                => ':attribute turi būti masyvas.',
    'before'               => ':attribute turi būti data prieš :date.',
    'before_or_equal'      => ':attribute privalo būti data ankstesnė arba lygi :date.',
    'between'              => [
        'numeric' => ':attribute privalo būti tarp :min - :max.',
        'file'    => ':attribute privalo būti tarp :min - :max kilobaitų.',
        'string'  => ':attribute privalo būti tarp :min - :max simbolių.',
        'array'   => ':attribute turi būti tarp :min ir :max elementų.',
    ],
    'boolean'              => ':attribute turi būti „Teisinga“ arba „Klaidinga“.',
    'confirmed'            => ':attribute patvirtinimas nesutampa.',
    'date'                 => ':attribute nėra galiojanti data.',
    'date_format'          => ':attribute neatitinka formato :format.',
    'different'            => ':attribute ir :other turi būti skirtingi.',
    'digits'               => ':attribute privalo būti :digits skaitmenų.',
    'digits_between'       => ':attribute privalo būti tarp :min ir:max skaitmenų.',
    'dimensions'           => ':attribute atvaizdo matmenys yra netinkami.',
    'distinct'             => ':attribute lauke yra pasikartojanti reikšmė.',
    'email'                => ':attribute formatas neteisingas.',
    'exists'               => 'Pasirinktas :attribute yra neteisingas.',
    'file'                 => ':attribute turi būti failas.',
    'filled'               => ':attribute laukas turi turėti reikšmę.',
    'image'                => ':attribute privalo būti atvaizdas.',
    'import_field_empty'    => ':fieldname reikšmė negali būti tuščia.',
    'in'                   => 'Pasirinktas :attribute neteisingas.',
    'in_array'             => 'Lauko :attribute nėra :other.',
    'integer'              => ':attribute turi būti sveikas skaičius.',
    'ip'                   => ':attribute privalo būti tinkamas IP adresas.',
    'ipv4'                 => ':attribute privalo būti tinkamas IPv4 adresas.',
    'ipv6'                 => ':attribute privalo būti tinkamas IPv6 adresas.',
    'is_unique_department' => ':attribute turi būti unikalus šiai įmonės vietai',
    'json'                 => ':attribute turi būti tinkama JSON eilutė.',
    'max'                  => [
        'numeric' => ':attribute negali būti didesnis nei :max.',
        'file'    => ':attribute negali būti didesnis nei :max kilobaitų.',
        'string'  => ':attribute negali būti didesnis nei :max simboliai.',
        'array'   => ':attribute negali turėti daugiau nei :max elementų.',
    ],
    'mimes'                => ':attribute privalo būti failas, kurio formatas :values.',
    'mimetypes'            => ':attribute turi būti failas, kurio formatas: :values.',
    'min'                  => [
        'numeric' => ':attribute privalo būti ne mažesnis nei :min.',
        'file'    => ':attribute turi būti bent :min kilobaitų.',
        'string'  => ':attribute privalo būti bent :min simbolių.',
        'array'   => ':attribute turi turėti bent :min elementų.',
    ],
    'starts_with'          => ':attribute turi prasidėti viena iš šių: :values.',
    'ends_with'            => ':attribute turi baigtis viena iš šių: :values.',

    'not_in'               => 'Pasirinktas :attribute yra neteisingas.',
    'numeric'              => ':attribute privalo būti skaičius.',
    'present'              => 'Laukas :attribute turi būti pateiktas.',
    'valid_regex'          => 'Tai nėra tinkamas regex. ',
    'regex'                => ':attribute formatas neteisingas.',
    'required'             => ':attribute laukas yra privalomas.',
    'required_if'          => ':attribute laukas yra privalomas, kai :other yra :value.',
    'required_unless'      => ':attribute laukas yra būtinas, nebent :other yra :values.',
    'required_with'        => ':attribute laukas yra privalomas, kai :values yra nurodyta.',
    'required_with_all'    => 'Laukas :attribute yra privalomas, kai :values yra nurodyta.',
    'required_without'     => ':attribute laukelis privalomas kai :values yra nenurodytas.',
    'required_without_all' => 'Atributo laukas reikalingas, kai nėra nė vieno iš: vertės.',
    'same'                 => ':attribute ir :other privalo sutapti.',
    'size'                 => [
        'numeric' => ':attribute privalo būti :size.',
        'file'    => ':attribute privalo būti :size kilobaitų.',
        'string'  => ':attribute privalo būti :size ženklų.',
        'array'   => 'Atributas turi būti: dydžio elementai.',
    ],
    'string'               => ':attribute turi būti eilutė.',
    'timezone'             => ':attribute turi būti tinkama zona.',
    'two_column_unique_undeleted' => ':attribute turi būti unikalus :table1 ir :table2. ',
    'unique'               => ':attribute jau užimtas.',
    'uploaded'             => ':attribute įkelti nepavyko.',
    'url'                  => ':attribute formatas neteisingas.',
    'unique_undeleted'     => ':attribute turi būti unikalus.',
    'non_circular'         => ':attribute neturi kurti žiedinės nuorodos.',
    'not_array'            => ':attribute negali būti masyvas.',
    'disallow_same_pwd_as_user_fields' => 'Slaptažodis negali sutapti su naudotojo vardu.',
    'letters'              => 'Slaptažodyje turi būti bent viena raidė.',
    'numbers'              => 'Slaptažodyje turi būti bent vienas skaičius.',
    'case_diff'            => 'Slaptažodyje turi būti naudojamos didžiosios ir mažosios raidės.',
    'symbols'              => 'Slaptažodyje turi būti simbolių.',
    'gte'                  => [
        'numeric'          => 'Reikšmė negali būti neigiama'
    ],
    'checkboxes'           => ':attribute yra neteisingų parinkčių.',
    'radio_buttons'        => ':atributas yra neteisingas.',


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
        'alpha_space' => 'Lauke :attribute yra simbolis, kurio negalima naudoti.',
        'email_array'      => 'Vienas ar keli el. pašto adresai yra neteisingi.',
        'hashed_pass'      => 'Jūsų dabartinis slaptažodis yra neteisingas',
        'dumbpwd'          => 'Šis slaptažodis yra per dažnas.',
        'statuslabel_type' => 'Turite pasirinkti tinkamą būsenos žymos tipą',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => ':attribute turi būti galiojanti data YYYY-MM-DD formatu',
        'last_audit_date.date_format'   =>  ':attribute turi būti galiojanti data YYYY-MM-DD hh:mm:ss formatu',
        'expiration_date.date_format'   =>  ':attribute turi būti galiojanti data YYYY-MM-DD formatu',
        'termination_date.date_format'  =>  ':attribute turi būti galiojanti data YYYY-MM-DD formatu',
        'expected_checkin.date_format'  =>  ':attribute turi būti galiojanti data YYYY-MM-DD formatu',
        'start_date.date_format'        =>  ':attribute turi būti galiojanti data YYYY-MM-DD formatu',
        'end_date.date_format'          =>  ':attribute turi būti galiojanti data YYYY-MM-DD formatu',

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
    'invalid_value_in_field' => 'Į šį lauką įtraukta netinkama reikšmė',
];
