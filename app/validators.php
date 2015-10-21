<?php

Validator::extend('alpha_space', function ($attribute,$value,$parameters) {
    return preg_match("/^[\s\n\-+:?#{}@*=;%$&ß\"~'\/\(\)_,!.a-zA-Z0-9\pL\pN\pM_-]+$/um",$value);
    // whitespace, newline, -, +, :, ?, #, ~, ', /, (, ), _, ',', !, ., a-z, A-Z, 0-9,
    //   Unicode Letter (\pL), Unicode Number (\pN), Unicode Spacing Combining Mark (\p{Mc} (eastern language vowels)), _ (again?), - (again?)
    // patterm must be matched at least once (empty strings will not pass)
    // (ungreedy?!) ,multiline
});


Validator::extend('unique_multiple', function ($attribute, $value, $parameters)
{
    // Get table name from first parameter
    $table = array_shift($parameters);

    // Build the query
    $query = DB::table($table);

    // Add the field conditions
    foreach ($parameters as $i => $field)
        $query->where($field, $value[$i]);

    // Validation result will be false if any rows match the combination
    return ($query->count() == 0);
});

Validator::extend('unique_column',function ($attribute,$value,$parameters) {
  
  return false;
});
