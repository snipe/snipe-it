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

    'accepted'             => ':attribute jābūt pieņemtam.',
    'active_url'           => ':attribute nav derīgs URL.',
    'after'                => ':attribute jābūt datumam pēc :date.',
    'after_or_equal'       => ':attribute jābūt datumam pēc :date.',
    'alpha'                => ':attribute var saturēt tikai burtus.',
    'alpha_dash'           => ':attribute var saturēt tikai burtus, ciparus un domuzīmes.',
    'alpha_num'            => ':attribute var saturēt tikai burtus un ciparus.',
    'array'                => ':attribute jābūt masīvam.',
    'before'               => ':attribute jābūt datumam pirms :date.',
    'before_or_equal'      => ':attribute jābūt datumam pirms vai vienādam ar :date.',
    'between'              => [
        'numeric' => ':attribute jābūt starp :min un :max.',
        'file'    => ':attribute jābūt starp :min un :max kilobaitiem.',
        'string'  => ':attribute jābūt no :min līdz :max rakstzīmēm.',
        'array'   => ':attribute jābūt starp :min un :max vienībām.',
    ],
    'boolean'              => ':attribute jābūt patiesam vai nepatiesam.',
    'confirmed'            => ':attribute apstiprinājums neatbilst.',
    'date'                 => ':attribute nav derīgs datums.',
    'date_format'          => ':attribute neatbilst formātam :format.',
    'different'            => ':attribute un :other jābūt atšķirīgiem.',
    'digits'               => ':attribute jābūt :digits cipariem.',
    'digits_between'       => ':attribute jābūt starp :min un :max cipariem.',
    'dimensions'           => ':attribute ir nederīgi attēla izmēri.',
    'distinct'             => ':attribute laukam ir dublikāta vērtība.',
    'email'                => ':attribute formāts ir nederīgs.',
    'exists'               => 'Atlasītais :attribute nav derīgs.',
    'file'                 => ':attribute ir jābūt failam.',
    'filled'               => ':attribute laukam jābūt vērtībai.',
    'image'                => ':attribute ir jābūt attēlam.',
    'in'                   => 'Atlasītais :attribute nav derīgs.',
    'in_array'             => ':attribute lauks neeksistē :other laukos.',
    'integer'              => ':attribute ir jābūt veselam skaitlim.',
    'ip'                   => ':attribute jābūt derīgai IP adresei.',
    'ipv4'                 => ':attribute jābūt derīgai IPv4 adresei.',
    'ipv6'                 => ':attribute jābūt derīgai IPv6 adresei.',
    'json'                 => ':attribute jābūt derīgai JSON virknei.',
    'max'                  => [
        'numeric' => ':attribute nedrīkst būt lielāks par :max.',
        'file'    => ':attribute nedrīkst būt lielāks par :max kilobaitiem.',
        'string'  => ':attribute nedrīkst būt vairāk par :max rakstzīmēm.',
        'array'   => ':attribute nedrīkst būt vairāk par :max vienībām.',
    ],
    'mimes'                => ':attribute jābūt failam ar tipu: :values.',
    'mimetypes'            => ':attribute jābūt failam ar tipu: :values.',
    'min'                  => [
        'numeric' => ':attribute jābūt vismaz :min.',
        'file'    => ':attribute jābūt vismaz :min kilobaitiem.',
        'string'  => ':attribute jābūt vismaz :min rakstzīmēm.',
        'array'   => ':attribute jābūt vismaz :min vienībām.',
    ],
    'not_in'               => 'Atlasītais :attribute nav derīgs.',
    'numeric'              => ':attribute ir jābūt skaitlim.',
    'present'              => 'Jābūt iekļautam :attribute laukam.',
    'valid_regex'          => 'Tas nav derīgs regex.',
    'regex'                => ':attribute formāts nav derīgs.',
    'required'             => 'Nepieciešams :attribute lauks.',
    'required_if'          => 'Nepieciešams :attribute lauks, ja :other vērtība ir :value.',
    'required_unless'      => 'Nepieciešams :attribute lauks, ja vien :other ir iekļauts vērtībās :values.',
    'required_with'        => 'Nepieciešams :attribute lauks, ja ir :values.',
    'required_with_all'    => 'Nepieciešams :attribute lauks, ja ir :values.',
    'required_without'     => 'Nepieciešams :attribute lauks, ja nav :values.',
    'required_without_all' => 'Nepieciešams :attribute lauks, ja neviena nav neviena no :values vērtības.',
    'same'                 => 'Attribūtam :attribute un :other jāsakrīt.',
    'size'                 => [
        'numeric' => ':attribute jābūt :size lielam.',
        'file'    => ':attribute jābūt :size kilobaitu lielam.',
        'string'  => ':attribute jābūt :size burtiem.',
        'array'   => ':attribute jāiekļauj :size vienības.',
    ],
    'string'               => ':attribute jābūt virknei.',
    'timezone'             => ':attribute jābūt derīgai zonai.',
    'unique'               => ':attribute jau ir aizņemts.',
    'uploaded'             => ':attribute neizdevās augšupielādēt.',
    'url'                  => ':attribute formāts nav derīgs.',
    "unique_undeleted"     => ":attribute jābūt unikālam.",

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
        'alpha_space' => ":attribute laukā ir rakstzīme, kas nav atļauta.",
        "email_array"      => "Viena vai vairākas e-pasta adreses nav derīgas.",
        "hashed_pass"      => "Jūsu pašreizējā parole nav pareiza",
        'dumbpwd'          => 'Šī parole ir pārāk izplatīta.',
        "statuslabel_type" => "Jums ir jāizvēlas derīgs statusa apzīmējuma veids",
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
