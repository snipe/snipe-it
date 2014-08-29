<?php
/**
* Macro helpers
*
*/

/**
* Country macro
* Generates the dropdown menu of countries for the profile form
*/
Form::macro('countries', function ($name = "country", $selected = null, $class = null) {

    $countries = Country::all();
    
    $select = '<select name="'.$name.'" class="'.$class.'" style="min-width:350px">';

    foreach ($countries as $country ) {
        $select .= '<option value="'.$country->code.'"'.($selected == $country->code ? ' selected="selected"' : '').'>'.$country->name.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
