<?php

Validator::extend('alpha_space', function ($attribute,$value,$parameters) {
    return preg_match("/^[\s\n\-+:?#~'\/\(\)_,!.a-zA-Z0-9\pL\pN\pM_-]+$/um",$value);
    // whitespace, newline, -, +, :, ?, #, ~, ', /, (, ), _, ',', !, ., a-z, A-Z, 0-9, 
    //   Unicode Letter (\pL), Unicode Number (\pN), Unicode Spacing Combining Mark (\p{Mc} (eastern language vowels)), _ (again?), - (again?)
    // patterm must be matched at least once (empty strings will not pass)
    // (ungreedy?!) ,multiline 
});
