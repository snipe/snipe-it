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

    "accepted"         => "il  :attribute è stato accettato.",
    "active_url"       => ":attribute non è un URL valido.",
    "after"            => ":attribute deve essere una data oltre il  :date.",
    "alpha"            => ":attribute può contenere solo lettere.",
    "alpha_dash"       => ":attribute può contenere solo lettere numeri e trattini.",
    "alpha_num"        => ":attribute può contenere solo lettere e numeri.",
    "before"           => ":attribute deve essere una data dopo :date.",
    "between"          => array(
        "numeric" => ":attribute deve essere tra  :min - :max.",
        "file"    => "il :attribute deve essere tra  :min - :max kilobytes.",
        "string"  => "il :attribute deve essere tra :min - :max caratteri.",
    ),
    "confirmed"        => "il :attribute non corrisponde.",
    "date"             => "la :attribute non è valida.",
    "date_format"      => "il :attribute non corrisponde al :format.",
    "different"        => "il :attribute e :other devono essere differenti.",
    "digits"           => "il :attribute deve essere :digits digits.",
    "digits_between"   => "il  :attribute deve essere tra :min e :max digits.",
    "email"            => "il formato del :attribute è invalido.",
    "exists"           => ":attribute selezzionato è invalido.",
    "email_array"      => "Una o più email sono invalidi.",
    "image"            => "il :attribute deve essere un immagine.",
    "in"               => "Il selezionato :attribute è invalido.",
    "integer"          => "L' :attribute deve essere un numero intero.",
    "ip"               => "L' :attribute deve essere un indirizzo IP valido.",
    "max"              => array(
        "numeric" => "L' :attribute non può essere superiore di :max.",
        "file"    => "L' :attribute non può essere maggiore di :max kilobytes.",
        "string"  => "L' :attribute non può essere maggiore di :max caratteri.",
    ),
    "mimes"            => "L' :attribute deve essere un file di type: :values.",
    "min"              => array(
        "numeric" => "L' :attribute deve essere almeno :min.",
        "file"    => "L' :attribute deve essere almeno :min kilobytes.",
        "string"  => "L' :attribute deve essere almeno :min caratteri.",
    ),
    "not_in"           => "L' :attribute selezionato è invalido.",
    "numeric"          => "L' :attribute deve essere un numero.",
    "regex"            => "Il formato dell' :attribute è invalido.",
    "required"         => "Il campo :attribute è obblogatorio.",
    "required_if"      => "L' :attribute è richiesto quando :other è :value.",
    "required_with"    => "Il campo :attribute è richiesto quando :values è presente.",
    "required_without" => "Il campo :attribute è richiesto quando :values non è presente.",
    "same"             => "L' :attribute e :other devono corrispondere.",
    "size"             => array(
        "numeric" => "L' :attribute deve essere :size.",
        "file"    => "L' :attribute deve essere :size kilobytes.",
        "string"  => "L' :attribute deve essere :size characters.",
    ),
    "unique"           => "L' :attribute è già stato preso.",
    "url"              => "Il formato dell' :attribute è invalido.",
    "statuslabel_type" => "Devi selezionare un tipo di stato valido",
    "unique_undeleted" => "L'attributo deve essere univoco.",


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

    'custom' => array(),
    'alpha_space' => "Il campo :attribute contiene un carattere che non è permesso.",

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

    'attributes' => array(),

);
