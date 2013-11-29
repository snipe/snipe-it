<?php

Validator::extend('alpha_space', function($attribute,$value,$parameters)
{
	return preg_match("/^[-+:?'()_,!. a-zA-Z0-9]+$/",$value);
});
