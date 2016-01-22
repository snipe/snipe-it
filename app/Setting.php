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

    public function show_custom_css() {
        $custom_css = Setting::getSettings()->custom_css;
        $custom_css = e($custom_css);
        // Needed for modifying the bootstrap nav :(
        $custom_css = str_ireplace('script','SCRIPTS-NOT-ALLOWED-HERE',$custom_css);
        $custom_css = str_replace('&gt;','>',$custom_css);
        return $custom_css;
    }

    /**
    * Converts bytes into human readable file size.
    *
    * @param string $bytes
    * @return string human readable file size (2,87 Мб)
    * @author Mogilev Arseny
    */
    public static function fileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
            $arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = round($result,2) .$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

}
