<?php

class Setting extends Elegant
{
    public static function getSettings()
    {
        static $static_cache = NULL;

        if (!$static_cache) {
            $static_cache = Setting::find(1);
        }
        return $static_cache;
    }

    public function lar_ver()
    {
    	$app = App::getFacadeApplication();
        return $app::VERSION;
    }
    
    public static function getDefaultEula() { 
	      
	    $Parsedown = new Parsedown();
	    if (Setting::getSettings()->default_eula_text) {
		    return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
	    } else {
		    return null;
	    } 
	    
    }
}
