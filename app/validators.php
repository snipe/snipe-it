<?php

Validator::extend('alpha_space', function($attribute,$value,$parameters)
{
	return preg_match("/^[\n-+:?#~'\/\(\)-_,!. a-zA-Z0-9]+$/m",$value);
});
