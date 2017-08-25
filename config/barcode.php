<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Barcode reader configuration
    |--------------------------------------------------------------------------
    |
    | This configuration allows you to read barcode from Label
	| and redirect you to specific Asset
    | Barcode reader need configuration for PREFIX (Default: ~) and SUFFIX (Default: \r -> Enter)
    |
    */
	"reader_active" => true,

	"prefix" => ord( "~" ),

	"suffix" => ord( "\r" ),

	/**
	 * Limit is a failsafe in case PREFIX char comes from keyboard and not from Barcode Reader
	 */
	"limit" => 30,
];