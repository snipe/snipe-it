<?php

class Setting extends Elegant {


	public static function getSettings()
	{
		static $static_cache = NULL;

		if (!$static_cache) {
			$static_cache = Setting::find(1);
		}
		return $static_cache;

	}

}
