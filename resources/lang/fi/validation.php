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

    'accepted'             => ':attribute tulee hyväksyä.',
    'active_url'           => ':attribute ei ole oikea URL-osoite.',
    'after'                => ':attribute tulee olla päivämäärä päivän :date jälkeen.',
    'after_or_equal'       => ':attribute päivämäärä on oltava jälkeen tai sama kuin :date.',
    'alpha'                => ':attribute saa sisältää ainoastaan kirjaimia.',
    'alpha_dash'           => ':attribute voi sisältää vain kirjaimia, numeroita ja viivoja.',
    'alpha_num'            => ':attribute voi sisältää ainoastaan kirjaimia ja numeroita.',
    'array'                => ':attribute on oltava rivi.',
    'before'               => ':attribute tulee olla päivämäärä ennen päivää :date.',
    'before_or_equal'      => ':attribute on oltava päivä ennen tai yhtä kuin :date.',
    'between'              => [
        'numeric' => ':attribute tulee olla välillä :min - :max.',
        'file'    => ':attribute tulee olla välillä :min - :max kilotavua.',
        'string'  => ':attribute tulee olla :min - :max merkkiä.',
        'array'   => ':attribute on oltava välillä :min ja :max.',
    ],
    'boolean'              => ':attribute on oltava tosi tai epätosi.',
    'confirmed'            => ':attribute vahvistus ei täsmää.',
    'date'                 => ':attribute ei ole oikea päivämäärä.',
    'date_format'          => ':attribute ei täsmää muotoiluun :format.',
    'different'            => ':attribute ja :other tulee olla erilaisia.',
    'digits'               => ':attribute tulee olla :digits numeroa pitkä.',
    'digits_between'       => ':attribute tulee olla numero väliltä :min ja :max.',
    'dimensions'           => ':attribute on virheelliset kuvamitat.',
    'distinct'             => 'Ominaisuuskentässä on kaksoiskappale.',
    'email'                => ':attribute muotoilu on virheellinen.',
    'exists'               => 'Valittu :attribute on virheellinen.',
    'file'                 => ':attribute on oltava tiedosto.',
    'filled'               => ':attribute kentässä on oltava arvo.',
    'image'                => ':attribute tulee olla kuva.',
    'in'                   => 'Valittu :attribute on virheellinen.',
    'in_array'             => ':attribute ei ole kentässä :other.',
    'integer'              => ':attribute tulee olla kokonaisluku.',
    'ip'                   => ':attribute tulee olla oikea IP-osoite.',
    'ipv4'                 => ':attribute on oltava kelvollinen IPv4-osoite.',
    'ipv6'                 => ':attribute on oltava kelvollinen IPv6-osoite.',
    'json'                 => ':attribute on oltava kelvollinen JSON-merkkijono.',
    'max'                  => [
        'numeric' => ':attribute ei saa olla suurempi kuin :max.',
        'file'    => ':attribute ei saa olla suurempi kuin :max kilotavua.',
        'string'  => ':attribute ei saa olla suurempi kuin :max merkkiä.',
        'array'   => ':attribute ei saa olla enempää kuin :max kohdetta.',
    ],
    'mimes'                => ':attribute tulee olla tiedosto jonka type: :values.',
    'mimetypes'            => ':attribute tulee olla tiedosto jonka type: :values.',
    'min'                  => [
        'numeric' => ':attribute tulee olla vähintään :min.',
        'file'    => ':attribute tulee olla vähintään :min kilotavua.',
        'string'  => ':attribute tulee olla vähintään :min merkkiä.',
        'array'   => ':attribute on oltava vähintään :min kohdetta.',
    ],
    'not_in'               => 'Valittu :attribute on virheellinen.',
    'numeric'              => ':attribute tulee olla numero.',
    'present'              => ':attribute kentän on oltava läsnä.',
    'valid_regex'          => 'Tämä ei ole pätevä regex. ',
    'regex'                => ':attribute muotoilu on virheellinen.',
    'required'             => ':attribute on vaadittu.',
    'required_if'          => ':attribute tarvitaan kun :other on :value.',
    'required_unless'      => ':attribute tarvitaan, paitsi jos :other on :values.',
    'required_with'        => ':attribute tarvitaan kun :values on määritettynä.',
    'required_with_all'    => ':attribute tarvitaan, kun: arvot ovat läsnä.',
    'required_without'     => ':attribute tarvitaan, kun :values ei ole määritettynä.',
    'required_without_all' => ':attribute tarvitaan, kun mitään :values ei ole määritetty.',
    'same'                 => ':attribute ja :other tulee olla samat.',
    'size'                 => [
        'numeric' => ':attribute tulee olla :size.',
        'file'    => ':attribute tulee olla :size kilotavua.',
        'string'  => ':attribute tulee olla :size merkkiä.',
        'array'   => 'Attribuutin on sisällettävä :size kohdetta.',
    ],
    'string'               => 'Määritteen on oltava merkkijono.',
    'timezone'             => 'Attribuutin on oltava kelvollinen alue.',
    'unique'               => ':attribute on jo käytössä.',
    'uploaded'             => 'Attribuutti ei onnistunut latautumaan.',
    'url'                  => ':attribute muotoilu on virheellinen.',
    "unique_undeleted"     => ":attribute pitää olla ainutlaatuinen.",

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
        'alpha_space' => "Attribuutin kenttä sisältää merkin, jota ei sallita.",
        "email_array"      => "Yksi tai useampi sähköpostiosoite on virheellinen.",
        "hashed_pass"      => "Nykyinen salasanasi on virheellinen",
        'dumbpwd'          => 'Salasana on liian yleinen.',
        "statuslabel_type" => "Sinun on valittava kelvollinen tilamerkintä tyyppi",
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
