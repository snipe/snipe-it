<?php

Validator::extend('alpha_space', function($attribute,$value,$parameters)
{
	return preg_match("/^[\s\n\-+:?#~'\/\(\)_,!.a-zA-Z0-9\pL\pN_-]+$/um",$value);
});
