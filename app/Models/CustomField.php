<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;

class CustomField extends Model
{
    public $guarded=["id"];

    /**

    */
    public static $PredefinedFormats=[
        "ANY" => "",
        "ALPHA" => "alpha",
        "EMAIL" => "email",
        "DATE" => "date",
        "URL" => "url",
        "NUMERIC" => "numeric",
        "MAC" => "regex:/^[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}$/",
        "IP" => "ip",
    ];

    public $rules=[
      "name" => "required|unique:custom_fields"
    ];

    public static $table_name="assets";

    public static function name_to_db_name($name)
    {
        return "_snipeit_".preg_replace("/[^a-zA-Z0-9]/", "_", strtolower($name));
    }

    public static function boot()
    {
        self::creating(function ($custom_field) {

            if (Schema::hasColumn(CustomField::$table_name,$custom_field->db_column_name())) {
              //field already exists when making a new custom field; fail.
                return false;
            }

            Schema::table(CustomField::$table_name, function ($table) use ($custom_field) {
                $table->text($custom_field->db_column_name())->nullable();
            });

        });

        self::updating(function ($custom_field) {
            if ($custom_field->isDirty("name")) {
                if (Schema::hasColumn(CustomField::$table_name,$custom_field->db_column_name())) {
                  //field already exists when renaming a custom field
                    return false;
                }
                return Schema::table(CustomField::$table_name, function ($table) use ($custom_field) {
                  $table->renameColumn(self::name_to_db_name($custom_field->getOriginal("name")),$custom_field->db_column_name());
                });
            }
            return true;
        });

        self::deleting(function ($custom_field) {
            return Schema::table(CustomField::$table_name,function ($table) use ($custom_field) {
              $table->dropColumn(self::name_to_db_name($custom_field->getOriginal("name")));
            });
        });
    }

    public function fieldset()
    {
        return $this->belongsToMany('\App\Models\CustomFieldset'); //?!?!?!?!?!?
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

  //public function

  //need helper to go from regex->English
  //need helper to go from English->regex

  //need helper for save() stuff - basically to alter table for the fields in question

    public function check_format($value)
    {
        return preg_match('/^'.$this->attributes['format'].'$/', $value)===1;
    }

    public function db_column_name()
    {
        return self::name_to_db_name($this->name);
    }

    //mutators for 'format' attribute
    public function getFormatAttribute($value)
    {
        foreach (self::$PredefinedFormats as $name => $pattern) {
            if ($pattern===$value) {
                return $name;
            }
        }
        return $value;
    }

    public function setFormatAttribute($value)
    {
        if (isset(self::$PredefinedFormats[$value])) {
            $this->attributes['format']=self::$PredefinedFormats[$value];
        } else {
            $this->attributes['format']=$value;
        }
    }

    /**
     * Format a value string as an array for select boxes and checkboxes.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.4]
     * @return Array
     */
    public function formatFieldValuesAsArray() {
        $arr = preg_split("/\\r\\n|\\r|\\n/", $this->field_values);

        $result[''] = 'Select '.strtolower($this->format);

        for ($x = 0; $x < count($arr); $x++) {
            $arr_parts = explode('|', $arr[$x]);
            if ($arr_parts[0]!='') {
                if (key_exists('1',$arr_parts)) {
                    $result[$arr_parts[0]] = $arr_parts[1];
                } else {
                    $result[$arr_parts[0]] = $arr_parts[0];
                }
            }

        }


        return $result;
    }

    public function isFieldDecryptable($string) {
        if (($this->field_encrypted=='1') && ($string!='')) {
            return true;
        }
        return false;
    }




}
