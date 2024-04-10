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

    'accepted'             => ':attribute tulee hyväksyä.',
    'active_url'           => ':attribute ei ole oikea URL-osoite.',
    'after'                => ':attribute tulee olla päivämäärä päivän :date jälkeen.',
    'after_or_equal'       => ':attribute on oltava päivän jälkeen tai yhtä suuri kuin: date.',
    'alpha'                => ':attribute saa sisältää ainoastaan kirjaimia.',
    'alpha_dash'           => ':attribute voi sisältää vain kirjaimia, numeroita ja viivoja.',
    'alpha_num'            => ':attribute voi sisältää ainoastaan kirjaimia ja numeroita.',
    'array'                => ':attribute on oltava taulukko.',
    'before'               => ':attribute tulee olla päivämäärä ennen päivää :date.',
    'before_or_equal'      => ':attribute on oltava päivää ennen tai yhtä kuin :date.',
    'between'              => [
        'numeric' => ':attribute tulee olla välillä :min - :max.',
        'file'    => ':attribute tulee olla välillä :min - :max kilotavua.',
        'string'  => ':attribute tulee olla :min - :max merkkiä.',
        'array'   => ':attribute on oltava :min ja :max välillä.',
    ],
    'boolean'              => ':attribute on oltava tosi tai epätosi.',
    'confirmed'            => ':attribute vahvistus ei täsmää.',
    'date'                 => ':attribute ei ole oikea päivämäärä.',
    'date_format'          => ':attribute ei täsmää muotoiluun :format.',
    'different'            => ':attribute ja :other tulee olla erilaisia.',
    'digits'               => ':attribute tulee olla :digits numeroa pitkä.',
    'digits_between'       => ':attribute tulee olla numero väliltä :min ja :max.',
    'dimensions'           => ':attribute on virheelliset kuvamitat.',
    'distinct'             => ':attribute kentässä on duplikaatti arvo.',
    'email'                => ':attribute muotoilu on virheellinen.',
    'exists'               => 'Valittu :attribute on virheellinen.',
    'file'                 => ':attribute on oltava tiedosto.',
    'filled'               => ':attribute kentässä on oltava arvo.',
    'image'                => ':attribute tulee olla kuva.',
    'import_field_empty'    => 'Arvo :fieldname ei voi olla nolla.',
    'in'                   => 'Valittu :attribute on virheellinen.',
    'in_array'             => ':attribute ei ole olemassa : other.',
    'integer'              => ':attribute tulee olla kokonaisluku.',
    'ip'                   => ':attribute tulee olla oikea IP-osoite.',
    'ipv4'                 => ':attribute on oltava kelvollinen IPv4-osoite.',
    'ipv6'                 => ':attribute on oltava kelvollinen IPv6-osoite.',
    'is_unique_department' => 'Kentän :attribute tulee olla yksilöllinen tälle yrityksen sijainnille',
    'json'                 => ':attribute on oltava kelvollinen JSON-merkkijono.',
    'max'                  => [
        'numeric' => ':attribute ei saa olla suurempi kuin :max.',
        'file'    => ':attribute ei saa olla suurempi kuin :max kilotavua.',
        'string'  => ':attribute ei saa olla suurempi kuin :max merkkiä.',
        'array'   => ':attribute ei saa olla enempää kuin :max nimikettä.',
    ],
    'mimes'                => ':attribute tulee olla tiedosto jonka tyyppi on: :values.',
    'mimetypes'            => ':attribute on oltava tyyppiä tyyppi: :values.',
    'min'                  => [
        'numeric' => ':attribute tulee olla vähintään :min.',
        'file'    => ':attribute tulee olla vähintään :min kilotavua.',
        'string'  => ':attribute tulee olla vähintään :min merkkiä.',
        'array'   => ':attribute on oltava vähintään :min nimikettä.',
    ],
    'starts_with'          => 'Kentän :attribute tulee alkaa jollakin seuraavista: :values.',
    'ends_with'            => 'Kentän :attribute arvon tulee päättyä johonkin seuraavista: :values.',

    'not_in'               => 'Valittu :attribute on virheellinen.',
    'numeric'              => ':attribute tulee olla numero.',
    'present'              => ':attribute kentän on oltava määritettynä.',
    'valid_regex'          => 'Tuo ei ole kelvollinen regex. ',
    'regex'                => ':attribute muotoilu on virheellinen.',
    'required'             => ':attribute on vaadittu.',
    'required_if'          => ':attribute on vaadittu kun :other on :value.',
    'required_unless'      => ':attribute -kenttä on pakollinen, paitsi jos :other on :values.',
    'required_with'        => ':attribute on vaadittu kun :values on määritettynä.',
    'required_with_all'    => ':attribute -kenttä tarvitaan, kun :values on määritetty.',
    'required_without'     => ':attribute on vaadittu kun :values ei ole määritettynä.',
    'required_without_all' => ':attribute -kenttä on pakollinen, kun mitään :values ei ole määritetty.',
    'same'                 => ':attribute ja :other tulee olla samat.',
    'size'                 => [
        'numeric' => ':attribute tulee olla :size.',
        'file'    => ':attribute tulee olla :size kilotavua.',
        'string'  => ':attribute tulee olla :size merkkiä.',
        'array'   => ':attribute -kentän pitää sisältää :size nimikettä.',
    ],
    'string'               => ':attribute on oltava merkkijono.',
    'timezone'             => ':attribute tulee olla kelvollinen verkkoalue.',
    'two_column_unique_undeleted' => 'Kentän :attribute arvon on oltava yksilöllinen :table1 ja :table2. ',
    'unique'               => ':attribute on jo käytössä.',
    'uploaded'             => ':attribute -kenttää ei onnistuttu lähettämään.',
    'url'                  => ':attribute muotoilu on virheellinen.',
    'unique_undeleted'     => ':attribute on oltava ainutlaatuinen.',
    'non_circular'         => ':attribute ei saa luoda kehäviittausta.',
    'not_array'            => ':attribute ei voi olla taulukko.',
    'disallow_same_pwd_as_user_fields' => 'Salasana ei voi olla sama kuin käyttäjätunnus.',
    'letters'              => 'Salasanan tulee sisältää vähintään yksi kirjain.',
    'numbers'              => 'Salasanan tulee sisältää vähintään yksi numero.',
    'case_diff'            => 'Salasanassa on käytettävä sekamuotoista kirjainta.',
    'symbols'              => 'Salasanan tulee sisältää symboleja.',
    'gte'                  => [
        'numeric'          => 'Arvo ei voi olla negatiivinen'
    ],
    'checkboxes'           => ':attribute sisältää virheellisiä vaihtoehtoja.',
    'radio_buttons'        => ':attribute on virheellinen.',


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
        'alpha_space' => ':attribute -kenttä sisältää merkin, jota ei sallita.',
        'email_array'      => 'Yksi tai useampi sähköpostiosoite on virheellinen.',
        'hashed_pass'      => 'Nykyinen salasanasi on virheellinen',
        'dumbpwd'          => 'Salasana on liian yleinen.',
        'statuslabel_type' => 'Sinun on valittava kelvollinen tilamerkintätyyppi',

        // date_format validation with slightly less stupid messages. It duplicates a lot, but it gets the job done :(
        // We use this because the default error message for date_format is reflects php Y-m-d, which non-PHP
        // people won't know how to format. 
        'purchase_date.date_format'     => 'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',
        'last_audit_date.date_format'   =>  'Kentän :attribute arvon on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP hh:mm:ss',
        'expiration_date.date_format'   =>  'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',
        'termination_date.date_format'  =>  'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',
        'expected_checkin.date_format'  =>  'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',
        'start_date.date_format'        =>  'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',
        'end_date.date_format'          =>  'Attribuutin on oltava kelvollinen päivämäärä muodossa VVVV-KK-PP',

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
    'invalid_value_in_field' => 'Virheellinen arvo sisältyy tähän kenttään',
];
