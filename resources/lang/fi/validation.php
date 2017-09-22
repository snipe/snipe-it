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
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute saa sisältää ainoastaan kirjaimia.',
    'alpha_dash'           => ':attribute voi sisältää vain kirjaimia, numeroita ja viivoja.',
    'alpha_num'            => ':attribute voi sisältää ainoastaan kirjaimia ja numeroita.',
    'array'                => 'The :attribute must be an array.',
    'before'               => ':attribute tulee olla päivämäärä ennen päivää :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute tulee olla välillä :min - :max.',
        'file'    => ':attribute tulee olla välillä :min - :max kilotavua.',
        'string'  => ':attribute tulee olla :min - :max merkkiä.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute vahvistus ei täsmää.',
    'date'                 => ':attribute ei ole oikea päivämäärä.',
    'date_format'          => ':attribute ei täsmää muotoiluun :format.',
    'different'            => ':attribute ja :other tulee olla erilaisia.',
    'digits'               => ':attribute tulee olla :digits numeroa pitkä.',
    'digits_between'       => ':attribute tulee olla numero väliltä :min ja :max.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute muotoilu on virheellinen.',
    'exists'               => 'Valittu :attribute on virheellinen.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute tulee olla kuva.',
    'in'                   => 'Valittu :attribute on virheellinen.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute tulee olla kokonaisluku.',
    'ip'                   => ':attribute tulee olla oikea IP-osoite.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute ei saa olla suurempi kuin :max.',
        'file'    => ':attribute ei saa olla suurempi kuin :max kilotavua.',
        'string'  => ':attribute ei saa olla suurempi kuin :max merkkiä.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute tulee olla tiedosto jonka tyyppi on: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute tulee olla vähintään :min.',
        'file'    => ':attribute tulee olla vähintään :min kilotavua.',
        'string'  => ':attribute tulee olla vähintään :min merkkiä.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Valittu :attribute on virheellinen.',
    'numeric'              => ':attribute tulee olla numero.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute muotoilu on virheellinen.',
    'required'             => ':attribute on vaadittu.',
    'required_if'          => ':attribute on vaadittu kun :other on :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute on vaadittu kun :values on määritettynä.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute on vaadittu kun :values ei ole määritettynä.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute ja :other tulee olla samat.',
    'size'                 => [
        'numeric' => ':attributetulee olla :size.',
        'file'    => ':attribute tulee olla :size kilotavua.',
        'string'  => ':attribute tulee olla :size merkkiä.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute on jo käytössä.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute muotoilu on virheellinen.',

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
