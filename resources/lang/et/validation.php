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

    'accepted'             => 'Atribuut peab olema aktsepteeritav.',
    'active_url'           => 'Atribuut: ei ole kehtiv URL.',
    'after'                => 'Atribuut peab olema kuupäev pärast: kuupäev.',
    'after_or_equal'       => 'Atribuut peab olema kuupäev või kuupäev: kuupäev.',
    'alpha'                => 'Atribuut: võib sisaldada ainult tähti.',
    'alpha_dash'           => 'Atribuut: võib sisaldada ainult tähte, numbreid ja kriipsu.',
    'alpha_num'            => 'Atribuut: võib sisaldada ainult tähti ja numbreid.',
    'array'                => 'Atribuut peab olema massiiv.',
    'before'               => 'Atribuut peab olema kuupäev: kuupäev.',
    'before_or_equal'      => 'Atribuut peab olema kuupäev või kuupäev: kuupäev.',
    'between'              => [
        'numeric' => 'Atribuut peab olema vahemikus min ja max max.',
        'file'    => 'Atribuut peab olema vahemikus min ja max kilobaitides.',
        'string'  => 'Atribuut peab olema vahemikus min: max tähemärki.',
        'array'   => 'Atribuut peab olema vahemikus: min ja max max.',
    ],
    'boolean'              => 'Atribuudiväljadele peab olema tõene või vale.',
    'confirmed'            => 'Atribuudi kinnitus ei sobi.',
    'date'                 => 'Atribuut: ei ole kehtiv kuupäev.',
    'date_format'          => 'Atribuut: ei vasta vormingule: vorming.',
    'different'            => 'Atribuut: and: teine ​​peab olema erinev.',
    'digits'               => 'Atribuut peab olema: numbrite numbrid.',
    'digits_between'       => 'Atribuut peab olema vahemikus min ja max max.',
    'dimensions'           => 'Atribuudil on vale kujutise mõõtmed.',
    'distinct'             => 'Atribuudiväljal on duplikaadi väärtus.',
    'email'                => 'Atribuut peab olema kehtiv e-posti aadress.',
    'exists'               => 'Valitud atribuut on kehtetu.',
    'file'                 => 'Atribuut peab olema fail.',
    'filled'               => 'Atribuudiväljal peab olema väärtus.',
    'image'                => 'Atribuut peab olema pilt.',
    'in'                   => 'Valitud atribuut on kehtetu.',
    'in_array'             => 'Atribuudiväljal pole olemas: muud.',
    'integer'              => 'Atribuut peab olema täisarv.',
    'ip'                   => 'Atribuut peab olema kehtiv IP-aadress.',
    'ipv4'                 => 'Atribuut peab olema kehtiv IPv4 aadress.',
    'ipv6'                 => 'Atribuut peab olema kehtiv IPv6 aadress.',
    'json'                 => 'Atribuut peab olema kehtiv JSON-string.',
    'max'                  => [
        'numeric' => 'Atribuut: ei tohi olla suurem kui: maks.',
        'file'    => 'Atribuut: ei tohi olla suurem kui: max kilobaiti.',
        'string'  => 'Atribuut: ei tohi olla suurem kui: max tähemärki.',
        'array'   => 'Atribuut: ei tohi sisaldada rohkem kui: max elemente.',
    ],
    'mimes'                => 'Atribuut peab olema faili tüüp:: values.',
    'mimetypes'            => 'Atribuut peab olema faili tüüp:: values.',
    'min'                  => [
        'numeric' => 'Atribuut peab olema vähemalt: min.',
        'file'    => 'Atribuut peab olema vähemalt: min kilobaiti.',
        'string'  => 'Atribuut peab olema vähemalt: min tähemärki.',
        'array'   => 'Atribuudil peab olema vähemalt: min kirjeid.',
    ],
    'not_in'               => 'Valitud atribuut on kehtetu.',
    'numeric'              => 'Atribuut peab olema number.',
    'present'              => 'Atribuudiväli peab olema kohal.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'Atribuudivorming on vale.',
    'required'             => 'Atribuudiväljandus on kohustuslik.',
    'required_if'          => 'Atribuudiväljastus on vajalik, kui: muu on: väärtus.',
    'required_unless'      => 'Atribuudiväljandus on vajalik, välja arvatud juhul, kui: muu on: väärtused.',
    'required_with'        => 'Atribuudiväljund on vajalik, kui: väärtused on olemas.',
    'required_with_all'    => 'Atribuudiväljund on vajalik, kui: väärtused on olemas.',
    'required_without'     => 'Atribuudiväljund on vajalik, kui: väärtusi ei leidu.',
    'required_without_all' => 'Atribuudiväljund on vajalik, kui ükski: väärtusest pole olemas.',
    'same'                 => 'Atribuut:: ja teine ​​peab vastama.',
    'size'                 => [
        'numeric' => 'Atribuut peab olema: suurus.',
        'file'    => 'Atribuut peab olema: suurus kilobaitides.',
        'string'  => 'Atribuut peab olema: suuruse tähtedega.',
        'array'   => 'Atribuut peab sisaldama: suuruse elemente.',
    ],
    'string'               => 'Atribuut peab olema string.',
    'timezone'             => 'Atribuut peab olema kehtiv tsoon.',
    'unique'               => 'Atribuut: on juba võetud.',
    'uploaded'             => 'Atribuut ei õnnestunud üles laadida.',
    'url'                  => 'Atribuudivorming on vale.',
    "unique_undeleted"     => "The :attribute must be unique.",

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
        'alpha_space' => "Atribuudi väli sisaldab märk, mis pole lubatud.",
        "email_array"      => "Üks või mitu e-posti aadressi on kehtetu.",
        "hashed_pass"      => "Teie praegune parool on vale",
        'dumbpwd'          => 'See parool on liiga levinud.',
        "statuslabel_type" => "Peate valima kehtiva olekutüübi tüübi",
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
