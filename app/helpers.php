<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
if(!function_exists("ParseFloat")) {
  //this may be only necessary to run tests?
  function ParseFloat($floatString){ 
      
      // use comma for thousands until local info is property used
      $LocaleInfo = localeconv();
      //$thousands = isset($LocaleInfo["mon_thousands_sep"]) ? $LocaleInfo["mon_thousands_sep"] : ","; 
      //$floatString = str_replace($LocaleInfo["mon_thousands_sep"] , "", $floatString); 
      //$floatString = str_replace($LocaleInfo["decimal_point"] , ".", $floatString); 
      $floatString = str_replace("," , "", $floatString); 
      $floatString = str_replace($LocaleInfo["decimal_point"] , ".", $floatString); 
      return floatval($floatString); 
  } 
}
