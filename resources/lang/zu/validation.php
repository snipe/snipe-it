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

    'accepted'             => 'I: izimfanelo kufanele zamukelwe.',
    'active_url'           => 'I: imfanelo ayiyona i-URL evumelekile.',
    'after'                => 'I: imfanelo kufanele ibe usuku emva: idethi.',
    'after_or_equal'       => 'I: imfanelo kufanele ibe usuku olulandelayo noma olulingana nalokhu: usuku.',
    'alpha'                => 'I: imfanelo ingase ibe nezinhlamvu kuphela.',
    'alpha_dash'           => 'I: i-attribute ingaqukatha kuphela izinhlamvu, izinombolo, kanye nokudonswa.',
    'alpha_num'            => 'I: Imfanelo ingase ibe nezinhlamvu nezinombolo kuphela.',
    'array'                => 'I: imfanelo kufanele ibe i-array.',
    'before'               => 'I: Imfanelo kufanele ibe usuku ngaphambi: idethi.',
    'before_or_equal'      => 'I: imfanelo kufanele ibe usuku ngaphambi noma elilingana nalokhu: usuku.',
    'between'              => [
        'numeric' => 'I: imfanelo kufanele ibe phakathi: min futhi: max.',
        'file'    => 'I: imfanelo kufanele ibe phakathi: min futhi: max kilobyte.',
        'string'  => 'I: imfanelo kufanele ibe phakathi: min futhi: max izinhlamvu.',
        'array'   => 'I: imfanelo kufanele ibe phakathi kwe: min kanye: izinto eziningi.',
    ],
    'boolean'              => 'I: Insimu yemfanelo kufanele ibe yikho noma ingamanga.',
    'confirmed'            => 'I: imfanelo yokuqinisekisa ayifani.',
    'date'                 => 'I: imfanelo akuyona idethi evumelekile.',
    'date_format'          => 'I: imfanelo ayihambisani nefomethi: ifomethi.',
    'different'            => 'I: i-attribut futhi: enye kumele ihluke.',
    'digits'               => 'I: imfanelo kufanele ibe: amadijithi amadijithali.',
    'digits_between'       => 'I: imfanelo kufanele ibe phakathi: iminithi kanye: amadijithi amaningi.',
    'dimensions'           => 'I: imfanelo inezinhlobo zesithombe ezingavumelekile.',
    'distinct'             => 'I: insimu yemfanelo inenani eliphindwe kabili.',
    'email'                => 'I: imfanelo kufanele ibe ikheli le-imeyili elivumelekile.',
    'exists'               => 'Okukhethiwe: imfanelo ayivumelekile.',
    'file'                 => 'I: imfanelo kufanele ibe ifayela.',
    'filled'               => 'I: insimu yemfanelo kufanele ibe nenani.',
    'image'                => 'I: imfanelo kufanele ibe isithombe.',
    'in'                   => 'Okukhethiwe: imfanelo ayivumelekile.',
    'in_array'             => 'I: inkambu yokwazisa ayikho: enye.',
    'integer'              => 'I: imfanelo kufanele ibe inamba.',
    'ip'                   => 'I: imfanelo kufanele ibe ikheli le-IP elivumelekile.',
    'ipv4'                 => 'I: imfanelo kufanele ibe ikheli le-IPv4 elivumelekile.',
    'ipv6'                 => 'I: imfanelo kufanele ibe ikheli le-IPv6 elivumelekile.',
    'json'                 => 'I: imfanelo kufanele ibe yocingo oluvumelekile le-JSON.',
    'max'                  => [
        'numeric' => 'I: umqondo kungenzeka ukuthi awukhulu kun: max.',
        'file'    => 'I: I-attribute ingase ingabi mkhulu kune: ama-kilobytes amaningi.',
        'string'  => 'I: I-attribute ingase ingabi mkhulu kune: izinhlamvu eziphezulu.',
        'array'   => 'I: i-attribute ingase ingabi nalokhu: izinto eziningi.',
    ],
    'mimes'                => 'I: imfanelo kufanele ibe ifayela lohlobo:: amanani.',
    'mimetypes'            => 'I: imfanelo kufanele ibe ifayela lohlobo:: amanani.',
    'min'                  => [
        'numeric' => 'I: imfanelo kumele ibe okungenani: min.',
        'file'    => 'I: imfanelo kufanele ibe okungenani: min kilobytes.',
        'string'  => 'I: imfanelo kufanele ibe okungenani: izinhlamvu ezincane.',
        'array'   => 'I: i-attribut kumele ibe okungenani: min min.',
    ],
    'not_in'               => 'Okukhethiwe: imfanelo ayivumelekile.',
    'numeric'              => 'I: imfanelo kufanele ibe inombolo.',
    'present'              => 'I: insimu yemfanelo kufanele ibe khona.',
    'regex'                => 'I: ifomethi yokwaziswa ayivumelekile.',
    'required'             => 'I: insimu yemfanelo iyadingeka.',
    'required_if'          => 'I: Insimu yemfanelo iyadingeka uma: enye ingukuthi: inani.',
    'required_unless'      => 'I: insimu yemfanelo iyadingeka ngaphandle: enye ikhona: amanani.',
    'required_with'        => 'I: Insimu yemfanelo iyadingeka lapho: amanani ekhona.',
    'required_with_all'    => 'I: Insimu yemfanelo iyadingeka lapho: amanani ekhona.',
    'required_without'     => 'I: Insimu yemfanelo iyadingeka lapho: amanani engekho.',
    'required_without_all' => 'I: Insimu yemfanelo iyadingeka lapho kungekho namunye: amanani akhona.',
    'same'                 => 'I: i-attribut futhi: enye kufanele ifane.',
    'size'                 => [
        'numeric' => 'I: imfanelo kufanele ibe: usayizi.',
        'file'    => 'I: imfanelo kufanele ibe: ama-kilobytes wesayizi.',
        'string'  => 'I: imfanelo kufanele ibe: izinhlamvu zesayizi.',
        'array'   => 'I: imfanelo kufanele ibe nalokhu: izinto ezisayizi.',
    ],
    'string'               => 'I: imfanelo kufanele ibe yocingo.',
    'timezone'             => 'I: imfanelo kufanele ibe yindawo evumelekile.',
    'unique'               => 'I: imfanelo isivele ithathwe.',
    'uploaded'             => 'I: imfanelo ayihlulekile ukulayisha.',
    'url'                  => 'I: ifomethi yokwaziswa ayivumelekile.',
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
        'alpha_space' => "I: Insimu yemfanelo iqukethe umlingiswa ongavunyelwe.",
        "email_array"      => "Ikheli elilodwa noma ngaphezulu le-imeyili alivumelekile.",
        "hashed_pass"      => "Iphasiwedi yakho yamanje ayilungile",
        'dumbpwd'          => 'Lelo phasiwedi livame kakhulu.',
        "statuslabel_type" => "Kumele ukhethe uhlobo lwelebula lesimo esivumelekile",
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
