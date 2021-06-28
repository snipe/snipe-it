<?php
/**
* Macro helpers
*/

/**
 * Locale macro
 * Generates the dropdown menu of available languages
 */
Form::macro('locales', function ($name = 'locale', $selected = null, $class = null, $id = null) {
    $locales = [
      ''=> ' ',
      'en'=> 'English, US',
      'en-GB'=> 'English, UK',
      'af'=> 'Afrikaans',
      'ar'=> 'Arabic',
      'bg'=> 'Bulgarian',
      'zh-CN'=> 'Chinese Simplified',
      'zh-TW'=> 'Chinese Traditional',
      'hr'=> 'Croatian',
      'cs'=> 'Czech',
      'da'=> 'Danish',
      'nl'=> 'Dutch',
      'en-ID'=> 'English, Indonesia',
      'et'=> 'Estonian',
      'fil'=> 'Filipino',
      'fi'=> 'Finnish',
      'fr'=> 'French',
      'de'=> 'German',
      'el'=> 'Greek',
      'he'=> 'Hebrew',
      'hu'=> 'Hungarian',
      'is' => 'Icelandic',
      'id'=> 'Indonesian',
      'ga-IE'=> 'Irish',
      'it'=> 'Italian',
      'ja'=> 'Japanese',
      'ko'=> 'Korean',
      'lv'=>'Latvian',
      'lt'=> 'Lithuanian',
      'mk'=> 'Macedonian',
      'ms'=> 'Malay',
      'mi'=> 'Maori',
      'mn'=> 'Mongolian',
      'no'=> 'Norwegian',
      'fa'=> 'Persian',
      'pl'=> 'Polish',
      'pt-PT'=> 'Portuguese',
      'pt-BR'=> 'Portuguese, Brazilian',
      'ro'=> 'Romanian',
      'ru'=> 'Russian',
      'sr-CS' => 'Serbian (Latin)',
      'sl'=> 'Slovenian',
      'es-ES'=> 'Spanish',
      'es-CO'=> 'Spanish, Colombia',
      'es-MX'=> 'Spanish, Mexico',
      'es-VE'=> 'Spanish, Venezuela',
      'sv-SE'=> 'Swedish',
      'tl'=> 'Tagalog',
      'ta'=> 'Tamil',
      'th'=> 'Thai',
      'tr'=> 'Turkish',
      'uk'=> 'Ukranian',
      'vi'=> 'Vietnamese',
      'cy'=> 'Welsh',
      'zu'=> 'Zulu',
    ];

    $idclause = '';
    if ($id) {
        $idclause = " id='$id'";
    }
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:350px"'.$idclause.' aria-label="'.$name.'">';

    foreach ($locales as $abbr => $locale) {
        $select .= '<option value="'.$abbr.'"'.($selected == $abbr ? ' selected="selected"' : '').'>'.$locale.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

/**
 * Country macro
 * Generates the dropdown menu of countries for the profile form
 */
Form::macro('countries', function ($name = 'country', $selected = null, $class = null, $id = null) {
    $countries = [
    ''=>'Select a Country',
    'AC'=>'Ascension Island',
    'AD'=>'Andorra',
    'AE'=>'United Arab Emirates',
    'AF'=>'Afghanistan',
    'AG'=>'Antigua And Barbuda',
    'AI'=>'Anguilla',
    'AL'=>'Albania',
    'AM'=>'Armenia',
    'AN'=>'Netherlands Antilles',
    'AO'=>'Angola',
    'AQ'=>'Antarctica',
    'AR'=>'Argentina',
    'AS'=>'American Samoa',
    'AT'=>'Austria',
    'AU'=>'Australia',
    'AW'=>'Aruba',
    'AX'=>'Ãƒâ€¦land',
    'AZ'=>'Azerbaijan',
    'BA'=>'Bosnia And Herzegovina',
    'BB'=>'Barbados',
    'BE'=>'Belgium',
    'BD'=>'Bangladesh',
    'BF'=>'Burkina Faso',
    'BG'=>'Bulgaria',
    'BH'=>'Bahrain',
    'BI'=>'Burundi',
    'BJ'=>'Benin',
    'BM'=>'Bermuda',
    'BN'=>'Brunei Darussalam',
    'BO'=>'Bolivia',
    'BR'=>'Brazil',
    'BS'=>'Bahamas',
    'BT'=>'Bhutan',
    'BV'=>'Bouvet Island',
    'BW'=>'Botswana',
    'BY'=>'Belarus',
    'BZ'=>'Belize',
    'CA'=>'Canada',
    'CC'=>'Cocos (Keeling) Islands',
    'CD'=>'Congo (Democratic Republic)',
    'CF'=>'Central African Republic',
    'CG'=>'Congo (Republic)',
    'CH'=>'Switzerland',
    'CI'=>'Côte d\'Ivoire',
    'CK'=>'Cook Islands',
    'CL'=>'Chile',
    'CM'=>'Cameroon',
    'CN'=>'People\'s Republic of China',
    'CO'=>'Colombia',
    'CR'=>'Costa Rica',
    'CU'=>'Cuba',
    'CV'=>'Cape Verde',
    'CX'=>'Christmas Island',
    'CY'=>'Cyprus',
    'CZ'=>'Czech Republic',
    'DE'=>'Germany',
    'DJ'=>'Djibouti',
    'DK'=>'Denmark',
    'DM'=>'Dominica',
    'DO'=>'Dominican Republic',
    'DZ'=>'Algeria',
    'EC'=>'Ecuador',
    'EE'=>'Estonia',
    'EG'=>'Egypt',
    'ER'=>'Eritrea',
    'ES'=>'Spain',
    'ET'=>'Ethiopia',
    'EU'=>'European Union',
    'FI'=>'Finland',
    'FJ'=>'Fiji',
    'FK'=>'Falkland Islands (Malvinas)',
    'FM'=>'Micronesia, Federated States Of',
    'FO'=>'Faroe Islands',
    'FR'=>'France',
    'GA'=>'Gabon',
    'GD'=>'Grenada',
    'GE'=>'Georgia',
    'GF'=>'French Guiana',
    'GG'=>'Guernsey',
    'GH'=>'Ghana',
    'GI'=>'Gibraltar',
    'GL'=>'Greenland',
    'GM'=>'Gambia',
    'GN'=>'Guinea',
    'GP'=>'Guadeloupe',
    'GQ'=>'Equatorial Guinea',
    'GR'=>'Greece',
    'GS'=>'South Georgia And The South Sandwich Islands',
    'GT'=>'Guatemala',
    'GU'=>'Guam',
    'GW'=>'Guinea-Bissau',
    'GY'=>'Guyana',
    'HK'=>'Hong Kong',
    'HM'=>'Heard And Mc Donald Islands',
    'HN'=>'Honduras',
    'HR'=>'Croatia (local name: Hrvatska)',
    'HT'=>'Haiti',
    'HU'=>'Hungary',
    'ID'=>'Indonesia',
    'IE'=>'Ireland',
    'IL'=>'Israel',
    'IM'=>'Isle of Man',
    'IN'=>'India',
    'IO'=>'British Indian Ocean Territory',
    'IQ'=>'Iraq',
    'IR'=>'Iran, Islamic Republic Of',
    'IS'=>'Iceland',
    'IT'=>'Italy',
    'JE'=>'Jersey',
    'JM'=>'Jamaica',
    'JO'=>'Jordan',
    'JP'=>'Japan',
    'KE'=>'Kenya',
    'KG'=>'Kyrgyzstan',
    'KH'=>'Cambodia',
    'KI'=>'Kiribati',
    'KM'=>'Comoros',
    'KN'=>'Saint Kitts And Nevis',
    'KR'=>'Korea, Republic Of',
    'KW'=>'Kuwait',
    'KY'=>'Cayman Islands',
    'KZ'=>'Kazakhstan',
    'LA'=>'Lao People\'s Democratic Republic',
    'LB'=>'Lebanon',
    'LC'=>'Saint Lucia',
    'LI'=>'Liechtenstein',
    'LK'=>'Sri Lanka',
    'LR'=>'Liberia',
    'LS'=>'Lesotho',
    'LT'=>'Lithuania',
    'LU'=>'Luxembourg',
    'LV'=>'Latvia',
    'LY'=>'Libyan Arab Jamahiriya',
    'MA'=>'Morocco',
    'MC'=>'Monaco',
    'MD'=>'Moldova, Republic Of',
    'ME'=>'Montenegro',
    'MG'=>'Madagascar',
    'MH'=>'Marshall Islands',
    'MK'=>'Macedonia, The Former Yugoslav Republic Of',
    'ML'=>'Mali',
    'MM'=>'Myanmar',
    'MN'=>'Mongolia',
    'MO'=>'Macau',
    'MP'=>'Northern Mariana Islands',
    'MQ'=>'Martinique',
    'MR'=>'Mauritania',
    'MS'=>'Montserrat',
    'MT'=>'Malta',
    'MU'=>'Mauritius',
    'MV'=>'Maldives',
    'MW'=>'Malawi',
    'MX'=>'Mexico',
    'MY'=>'Malaysia',
    'MZ'=>'Mozambique',
    'NA'=>'Namibia',
    'NC'=>'New Caledonia',
    'NE'=>'Niger',
    'NF'=>'Norfolk Island',
    'NG'=>'Nigeria',
    'NI'=>'Nicaragua',
    'NL'=>'Netherlands',
    'NO'=>'Norway',
    'NP'=>'Nepal',
    'NR'=>'Nauru',
    'NU'=>'Niue',
    'NZ'=>'New Zealand',
    'OM'=>'Oman',
    'PA'=>'Panama',
    'PE'=>'Peru',
    'PF'=>'French Polynesia',
    'PG'=>'Papua New Guinea',
    'PH'=>'Philippines, Republic of the',
    'PK'=>'Pakistan',
    'PL'=>'Poland',
    'PM'=>'St. Pierre And Miquelon',
    'PN'=>'Pitcairn',
    'PR'=>'Puerto Rico',
    'PS'=>'Palestine',
    'PT'=>'Portugal',
    'PW'=>'Palau',
    'PY'=>'Paraguay',
    'QA'=>'Qatar',
    'RE'=>'Reunion',
    'RO'=>'Romania',
    'RS'=>'Serbia',
    'RU'=>'Russian Federation',
    'RW'=>'Rwanda',
    'SA'=>'Saudi Arabia',
    'UK'=>'Scotland',
    'SB'=>'Solomon Islands',
    'SC'=>'Seychelles',
    'SD'=>'Sudan',
    'SE'=>'Sweden',
    'SG'=>'Singapore',
    'SH'=>'St. Helena',
    'SI'=>'Slovenia',
    'SJ'=>'Svalbard And Jan Mayen Islands',
    'SK'=>'Slovakia (Slovak Republic)',
    'SL'=>'Sierra Leone',
    'SM'=>'San Marino',
    'SN'=>'Senegal',
    'SO'=>'Somalia',
    'SR'=>'Suriname',
    'ST'=>'Sao Tome And Principe',
    'SU'=>'Soviet Union',
    'SV'=>'El Salvador',
    'SY'=>'Syrian Arab Republic',
    'SZ'=>'Swaziland',
    'TC'=>'Turks And Caicos Islands',
    'TD'=>'Chad',
    'TF'=>'French Southern Territories',
    'TG'=>'Togo',
    'TH'=>'Thailand',
    'TJ'=>'Tajikistan',
    'TK'=>'Tokelau',
    'TI'=>'East Timor',
    'TM'=>'Turkmenistan',
    'TN'=>'Tunisia',
    'TO'=>'Tonga',
    'TP'=>'East Timor (old code)',
    'TR'=>'Turkey',
    'TT'=>'Trinidad And Tobago',
    'TV'=>'Tuvalu',
    'TW'=>'Taiwan',
    'TZ'=>'Tanzania, United Republic Of',
    'UA'=>'Ukraine',
    'UG'=>'Uganda',
    'UK'=>'United Kingdom',
    'US'=>'United States',
    'UM'=>'United States Minor Outlying Islands',
    'UY'=>'Uruguay',
    'UZ'=>'Uzbekistan',
    'VA'=>'Vatican City State (Holy See)',
    'VC'=>'Saint Vincent And The Grenadines',
    'VE'=>'Venezuela',
    'VG'=>'Virgin Islands (British)',
    'VI'=>'Virgin Islands (U.S.)',
    'VN'=>'Viet Nam',
    'VU'=>'Vanuatu',
    'WF'=>'Wallis And Futuna Islands',
    'WS'=>'Samoa',
    'YE'=>'Yemen',
    'YT'=>'Mayotte',
    'ZA'=>'South Africa',
    'ZM'=>'Zambia',
    'ZW'=>'Zimbabwe',
    ];

    $idclause = '';
    if ($id) {
        $idclause = " id='$id'";
    }
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:350px"'.$idclause.' aria-label="'.$name.'">';

    foreach ($countries as $abbr => $country) {
        $select .= '<option value="'.strtoupper($abbr).'"'.(strtoupper($selected) == strtoupper($abbr) ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$country.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

Form::macro('date_display_format', function ($name = 'date_display_format', $selected = null, $class = null) {
    $formats = [
        'Y-m-d',
        'D M d, Y',
        'M j, Y',
        'd M, Y',
        'm/d/Y',
        'n/d/y',
        'd/m/Y',
        'd.m.Y',
        'Y.m.d.',
    ];

    foreach ($formats as $format) {
        $date_display_formats[$format] = Carbon::parse(date('Y').'-'.date('m').'-25')->format($format);
    }
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:250px" aria-label="'.$name.'">';
    foreach ($date_display_formats as $format => $date_display_format) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'">'.$date_display_format.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

Form::macro('time_display_format', function ($name = 'time_display_format', $selected = null, $class = null) {
    $formats = [
        'g:iA',
        'h:iA',
        'H:i',
    ];

    foreach ($formats as $format) {
        $time_display_formats[$format] = Carbon::now()->format($format);
    }
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:150px" aria-label="'.$name.'">';
    foreach ($time_display_formats as $format => $time_display_format) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$time_display_format.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

Form::macro('digit_separator', function ($name = 'digit_separator', $selected = null, $class = null) {
    $formats = [
        '1,234.56',
        '1.234,56',
    ];

    foreach ($formats as $format) {
    }
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:120px">';
    foreach ($formats as $format_inner) {
        $select .= '<option value="'.$format_inner.'"'.($selected == $format_inner ? ' selected="selected"' : '').'>'.$format_inner.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

/**
 * Barcode macro
 * Generates the dropdown menu of available 1D barcodes
 */
Form::macro('alt_barcode_types', function ($name = 'alt_barcode', $selected = null, $class = null) {
    $barcode_types = [
        'C128',
        'C39',
        'PDF417',
        'EAN5',
        'EAN13',
        'UPCA',
        'UPCE',

    ];

    $select = '<select name="'.$name.'" class="'.$class.'" aria-label="'.$name.'">';
    foreach ($barcode_types as $barcode_type) {
        $select .= '<option value="'.$barcode_type.'"'.($selected == $barcode_type ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$barcode_type.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

/**
 * Barcode macro
 * Generates the dropdown menu of available 2D barcodes
 */
Form::macro('barcode_types', function ($name = 'barcode_type', $selected = null, $class = null) {
    $barcode_types = [
        'QRCODE',
        'DATAMATRIX',

    ];

    $select = '<select name="'.$name.'" class="'.$class.'" aria-label="'.$name.'">';
    foreach ($barcode_types as $barcode_type) {
        $select .= '<option value="'.$barcode_type.'"'.($selected == $barcode_type ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$barcode_type.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

Form::macro('username_format', function ($name = 'username_format', $selected = null, $class = null) {
    $formats = [
        'firstname.lastname' => trans('general.firstname_lastname_format'),
        'firstname' => trans('general.first_name_format'),
        'filastname' => trans('general.filastname_format'),
        'lastnamefirstinitial' => trans('general.lastnamefirstinitial_format'),
        'firstname_lastname' => trans('general.firstname_lastname_underscore_format'),
        'firstinitial.lastname' => trans('general.firstinitial.lastname'),
        'lastname_firstinitial' => trans('general.lastname_firstinitial'),
        'firstnamelastname' => trans('general.firstnamelastname'),
        'firstnamelastinitial' => trans('general.firstnamelastinitial'),
    ];

    $select = '<select name="'.$name.'" class="'.$class.'" style="width: 100%" aria-label="'.$name.'">';
    foreach ($formats as $format => $label) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$label.'</option> '."\n";
    }

    $select .= '</select>';

    return $select;
});

Form::macro('two_factor_options', function ($name = 'two_factor_enabled', $selected = null, $class = null) {
    $formats = [
        '' => trans('admin/settings/general.two_factor_disabled'),
        '1' => trans('admin/settings/general.two_factor_optional'),
        '2' => trans('admin/settings/general.two_factor_required'),

    ];

    $select = '<select name="'.$name.'" class="'.$class.'" aria-label="'.$name.'">';
    foreach ($formats as $format => $label) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$label.'</option> '."\n";
    }

    $select .= '</select>';

    return $select;
});

Form::macro('customfield_elements', function ($name = 'customfield_elements', $selected = null, $class = null) {
    $formats = [
        'text' => 'Text Box',
        'listbox' => 'List Box',
        'textarea' => 'Textarea (multi-line) ',
        'checkbox' => 'Checkbox',
        'radio' => 'Radio Buttons',
    ];

    $select = '<select name="'.$name.'" class="'.$class.'" style="width: 100%" aria-label="'.$name.'">';
    foreach ($formats as $format => $label) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$label.'</option> '."\n";
    }

    $select .= '</select>';

    return $select;
});

Form::macro('skin', function ($name = 'skin', $selected = null, $class = null) {
    $formats = [
        'blue' => 'Default Blue',
        'blue-dark' => 'Blue (Dark Mode)',
        'green' => 'Green Dark',
        'green-dark' => 'Green (Dark Mode)',
        'red' => 'Red Dark',
        'red-dark' => 'Red (Dark Mode)',
        'orange' => 'Orange Dark',
        'orange-dark' => 'Orange (Dark Mode)',
        'black' => 'Black',
        'black-dark' => 'Black (Dark Mode)',
        'purple' => 'Purple',
        'purple-dark' => 'Purple (Dark Mode)',
        'yellow' => 'Yellow',
        'yellow-dark' => 'Yellow (Dark Mode)',
        'contrast' => 'High Contrast',
    ];

    $select = '<select name="'.$name.'" class="'.$class.'" style="width: 250px" aria-label="'.$name.'">';
    foreach ($formats as $format => $label) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$label.'</option> '."\n";
    }

    $select .= '</select>';

    return $select;
});

Form::macro('user_skin', function ($name = 'skin', $selected = null, $class = null) {
    $formats = [
        '' => 'Site Default',
        'blue' => 'Default Blue',
        'blue-dark' => 'Blue (Dark Mode)',
        'green' => 'Green Dark',
        'green-dark' => 'Green (Dark Mode)',
        'red' => 'Red Dark',
        'red-dark' => 'Red (Dark Mode)',
        'orange' => 'Orange Dark',
        'orange-dark' => 'Orange (Dark Mode)',
        'black' => 'Black',
        'black-dark' => 'Black (Dark Mode)',
        'purple' => 'Purple',
        'purple-dark' => 'Purple (Dark Mode)',
        'yellow' => 'Yellow',
        'yellow-dark' => 'Yellow (Dark Mode)',
        'contrast' => 'High Contrast',
    ];

    $select = '<select name="'.$name.'" class="'.$class.'" style="width: 250px">';
    foreach ($formats as $format => $label) {
        $select .= '<option value="'.$format.'"'.($selected == $format ? ' selected="selected"' : '').'>'.$label.'</option> '."\n";
    }

    $select .= '</select>';

    return $select;
});
