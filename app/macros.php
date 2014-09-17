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

Form::macro('label_for', function ($class, $field, $label_text = null, $options = null)
{
    if($class->is_required($field))
    {
        $options['class'] = $options['class'] . ' required';
    }
    
    $output = Form::label($field, $label_text, $options);
         
    return HTML::decode($output);
        
});

Form::macro('text_for', function ($class, $field, $options = null, $errors = null)
{
    if($class->max_length($field))
    {
        $options['maxlength'] = $class->max_length($field);       
    }
    
    $output = Form::text($field, Input::old($field, $class->$field), $options);
    
    if($errors)
    {
        $output = $output . $errors->first($field, '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>');
    }
    
    return $output;
});
