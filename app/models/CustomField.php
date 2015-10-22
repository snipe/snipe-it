<?php

class CustomField extends Elegant
{
  public $guarded=["id"];
  public static $PredefinedFormats=[
    "ALPHA" => "[a-zA-Z]*",
    "NUMERIC" => "[0-9]*",
    "MAC" => "[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}",
    "IP" => "([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])"
  ];
  
  public static $table_name="assets";
  
  public static function name_to_db_name($name)
  {
    return "_snipeit_".preg_replace("/\s/","_",strtolower($name));
  }
  
  public static function boot()
  {
    self::creating(function ($custom_field) {
      
      if(in_array($custom_field->db_column_name(),Schema::getColumnListing(DB::getTablePrefix().CustomField::$table_name))) {
        //field already exists when making a new custom field; fail.
        return false;
      }
      return DB::statement("ALTER TABLE ".DB::getTablePrefix().CustomField::$table_name." ADD COLUMN (".$custom_field->db_column_name()." TEXT)");
    });
    
    self::updating(function ($custom_field) {
      //print("    SAVING CALLBACK FIRING!!!!!    ");
      if($custom_field->isDirty("name")) {
        //print("DIRTINESS DETECTED!");
        //$fields=array_keys($custom_field->getAttributes());
        //;
        //add timestamp fields, add id column
        //array_push($fields,$custom_field->getKeyName());
        /*if($custom_field::timestamps) {
          
        }*/
        //print("Fields are: ".print_r($fields,true));
        if(in_array($custom_field->db_column_name(),Schema::getColumnListing(CustomField::$table_name))) {
          //field already exists when renaming a custom field
          return false;
        }
        return DB::statement("UPDATE ".CustomField::$table_name." RENAME ".self::name_to_db_name($custom_field->get_original("name"))." TO ".$custom_field->db_column_name());
      }
      return true;
    });
  }
  
  /*public static function boot() {
    parent::boot();
    
    self::saving(function ($data) {
      print("DOES THIS AT LEAST CATCH IT?!");
      self::check_db_name($data);
    });
  }*/
  
  public function fieldset() {
    return $this->belongsToMany('CustomFieldset'); //?!?!?!?!?!?
  }
    
  //public function 
  
  //need helper to go from regex->English
  //need helper to go from English->regex
  
  //need helper for save() stuff - basically to alter table for the fields in question  

  public function check_format($value) {
    return preg_match('/^'.$this->attributes['format'].'$/',$value)===1;
  }
  
  public function db_column_name() {
    return self::name_to_db_name($this->name);
  }
  
  //mutators for 'format' attribute
  public function getFormatAttribute($value) {
    foreach(self::$PredefinedFormats AS $name => $pattern) {
      if($pattern===$value) {
        return $name;
      }
    }
    return $value;
  }

  public function setFormatAttribute($value) {
    if(isset(self::$PredefinedFormats[$value])) {
      $this->attributes['format']=self::$PredefinedFormats[$value];
    } else {
      $this->attributes['format']=$value;
    }
  }
}
