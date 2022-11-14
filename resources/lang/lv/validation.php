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

    'accepted'             => 'Atribūts jāpieņem.',
    'active_url'           => 'Atribūts nav derīgs URL.',
    'after'                => 'Atribūtam jābūt datumam pēc: datuma.',
    'after_or_equal'       => 'Atribūtam jābūt datumam pēc datuma vai pēc tā: datums.',
    'alpha'                => 'Atribūts var saturēt tikai burti.',
    'alpha_dash'           => 'Atribūts var saturēt tikai burti, ciparus un domuzīmes.',
    'alpha_num'            => 'Atribūts var saturēt tikai burti un ciparus.',
    'array'                => 'Atribūtam jābūt masīvam.',
    'before'               => 'Atribūtam jābūt datumam: datums.',
    'before_or_equal'      => 'Atribūtam jābūt datumam pirms vai vienāds ar: datumu.',
    'between'              => [
        'numeric' => 'Atribūtam jābūt starp: min un: max.',
        'file'    => 'Atribūtam jābūt starp: min un: max kilobaitiem.',
        'string'  => 'Atribūtam jābūt no: min un max max rakstzīmēm.',
        'array'   => 'Atribūtam jābūt starp: min un: max vienumiem.',
    ],
    'boolean'              => 'Atribūta laukam jābūt patiesam vai nepatiesam.',
    'confirmed'            => 'Atribūta apstiprinājums neatbilst.',
    'date'                 => 'Atribūts nav derīgs datums.',
    'date_format'          => 'Atribūts neatbilst formātam: formātā.',
    'different'            => 'Atribūts: un citam jābūt citam.',
    'digits'               => 'Atribūtam jābūt: ciparu cipariem.',
    'digits_between'       => 'Atribūtam jābūt starp: min un: max cipariem.',
    'dimensions'           => 'Atribūts: nederīgie attēla izmēri.',
    'distinct'             => 'Atribūta laukam ir dublikāta vērtība.',
    'email'                => 'Atribūtam jābūt derīgai e-pasta adresei.',
    'exists'               => 'Atlasītais: atribūts nav derīgs.',
    'file'                 => 'Atribūts ir jābūt failam.',
    'filled'               => 'Atribūta laukam jābūt vērtībai.',
    'image'                => 'Atribūts ir jābūt attēlam.',
    'in'                   => 'Atlasītais: atribūts nav derīgs.',
    'in_array'             => 'Atribūta lauks neeksistē: citā.',
    'integer'              => 'Atribūts ir jābūt veselam skaitlim.',
    'ip'                   => 'Atribūtam jābūt derīgai IP adresei.',
    'ipv4'                 => 'Atribūtam jābūt derīgai IPv4 adresei.',
    'ipv6'                 => 'Atribūtam jābūt derīgai IPv6 adresei.',
    'json'                 => 'Atribūtam jābūt derīgai JSON virknei.',
    'max'                  => [
        'numeric' => 'Atribūts: nedrīkst būt lielāks par: max.',
        'file'    => 'Atribūts: nedrīkst būt lielāks par: maks. Kilobaitus.',
        'string'  => 'Atribūts: nedrīkst būt lielāks par: max rakstzīmēm.',
        'array'   => 'Atribūts: nedrīkst būt vairāk par: max vienumiem.',
    ],
    'mimes'                => 'Atribūtam jābūt failam ar tipu:: values.',
    'mimetypes'            => 'Atribūtam jābūt failam ar tipu:: values.',
    'min'                  => [
        'numeric' => 'Atribūtam jābūt vismaz: min.',
        'file'    => 'Atribūtam jābūt vismaz: min kilobaitiem.',
        'string'  => 'Atribūts: jābūt vismaz: min rakstzīmēm.',
        'array'   => 'Atribūtam jābūt vismaz: min vienumiem.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'not_in'               => 'Atlasītais: atribūts nav derīgs.',
    'numeric'              => 'Atribūts ir jābūt skaitlim.',
    'present'              => 'Atribūta laukam jābūt klāt.',
    'valid_regex'          => 'regex nav derīgs.',
    'regex'                => 'Atribūta formāts nav derīgs.',
    'required'             => 'Atribūta lauks ir nepieciešams.',
    'required_if'          => 'Atribūta lauks ir nepieciešams, ja: cits ir: vērtība.',
    'required_unless'      => 'Atribūta lauks ir nepieciešams, ja vien: citā ir: vērtības.',
    'required_with'        => 'Atribūta lauks ir nepieciešams, ja: ir vērtības.',
    'required_with_all'    => 'Atribūta lauks ir nepieciešams, ja: ir vērtības.',
    'required_without'     => 'Atribūta lauks ir nepieciešams, ja: vērtības nav.',
    'required_without_all' => 'Atribūta lauks ir nepieciešams, ja neviena no: vērtības nav.',
    'same'                 => 'Atribūts: un citam jāatbilst.',
    'size'                 => [
        'numeric' => 'Atribūts: jābūt lielumam.',
        'file'    => 'Atribūts: jābūt kilobaitiem.',
        'string'  => 'Atribūts: jābūt lieluma burtiem.',
        'array'   => 'Atribūts: jāiekļauj: lieluma vienumi.',
    ],
    'string'               => 'Atribūtam jābūt virknei.',
    'timezone'             => 'Atribūtam jābūt derīgai zonai.',
    'unique'               => 'Atribūts jau ir pieņemts.',
    'uploaded'             => 'Atribūts neizdevās augšupielādēt.',
    'url'                  => 'Atribūta formāts nav derīgs.',
    'unique_undeleted'     => ':attribute jābūt unikālam.',
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
        'alpha_space' => 'Laukā: atribūta lauks ir rakstzīme, kas nav atļauta.',
        'email_array'      => 'Viena vai vairākas e-pasta adreses nav derīgas.',
        'hashed_pass'      => 'Jūsu pašreizējā parole nav pareiza',
        'dumbpwd'          => 'Šī parole ir pārāk izplatīta.',
        'statuslabel_type' => 'Jums ir jāizvēlas derīgs statusa etiķetes veids',
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
