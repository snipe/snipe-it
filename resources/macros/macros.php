<?php
/**
* Macro helpers
*/

/**
 * Locale macro
 * Generates the dropdown menu of available languages
 */
Form::macro('locales', function ($name = 'locale', $selected = null, $class = null, $id = null) {

    $idclause = (!is_null($id)) ? $id : '';

    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:350px"'.$idclause.' aria-label="'.$name.'" data-placeholder="'.trans('localizations.select_language').'">';
    $select .= '<option value=""  role="option">'.trans('localizations.select_language').'</option>';

    // Pull the autoglossonym array from the localizations translation file
    foreach (trans('localizations.languages') as $abbr => $locale) {
        $select .= '<option value="'.$abbr.'"'.(($selected == $abbr) ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$locale.'</option> ';
    }

    $select .= '</select>';

    return $select;
});

/**
 * Country macro
 * Generates the dropdown menu of countries for the profile form
 */
Form::macro('countries', function ($name = 'country', $selected = null, $class = null, $id = null) {

    $idclause = (!is_null($id)) ? $id : '';

    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:350px"'.$idclause.' aria-label="'.$name.'" data-placeholder="'.trans('localizations.select_country').'">';
    $select .= '<option value=""  role="option">'.trans('localizations.select_country').'</option>';

    // Pull the autoglossonym array from the localizations translation file
    foreach (trans('localizations.countries') as $abbr => $country) {
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
