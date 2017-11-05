<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;
use Watson\Validating\ValidatingTrait;
use App\Http\Traits\UniqueUndeletedTrait;
use ForceUTF8\Encoding;
use EasySlugger\Utf8Slugger;
use Patchwork\Utf8;

class CustomField extends Model
{
    use ValidatingTrait, UniqueUndeletedTrait;
    public $guarded=["id"];
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

    public $rules = [
        "name" => "required|unique:custom_fields"
    ];

    // This is confusing, since it's actually the custom fields table that
    // we're usually modifying, but since we alter the assets table, we have to
    // say that here
    public static $table_name = "assets";

    public static function name_to_db_name($name)
    {
        return "_snipeit_" . preg_replace("/[^a-zA-Z0-9]/", "_", strtolower($name));
    }

    public static function boot()
    {
        self::created(function ($custom_field) {

            // column exists - nothing to do here
            if (Schema::hasColumn(CustomField::$table_name, $custom_field->convertUnicodeDbSlug())) {
                return false;
            }

            Schema::table(CustomField::$table_name, function ($table) use ($custom_field) {
                $table->text($custom_field->convertUnicodeDbSlug())->nullable();
            });

            $custom_field->db_column = $custom_field->convertUnicodeDbSlug();
            $custom_field->save();
        });


        self::updating(function ($custom_field) {

             // Column already exists. Nothing to update.
            if ($custom_field->isDirty("name")) {
                if (Schema::hasColumn(CustomField::$table_name, $custom_field->convertUnicodeDbSlug())) {
                    return true;
                }

                // This is just a dumb thing we have to include because Laraval/Doctrine doesn't
                // play well with enums or a table that EVER had enums. :(
                $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
                $platform->registerDoctrineTypeMapping('enum', 'string');

                // Rename the field if the name has changed
                Schema::table(CustomField::$table_name, function ($table) use ($custom_field) {
                    $table->renameColumn($custom_field->convertUnicodeDbSlug($custom_field->getOriginal("name")), $custom_field->convertUnicodeDbSlug());
                });

                // Save the updated column name to the custom fields table
                $custom_field->db_column = $custom_field->convertUnicodeDbSlug();
                $custom_field->save();

                return true;
            }
            return true;
        });


        // Drop the assets column if we've deleted it from custom fields
        self::deleting(function ($custom_field) {
            return Schema::table(CustomField::$table_name, function ($table) use ($custom_field) {
                $table->dropColumn($custom_field->convertUnicodeDbSlug());
            });
        });
    }

    public function fieldset()
    {
        return $this->belongsToMany('\App\Models\CustomFieldset');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }


    public function check_format($value)
    {
        return preg_match('/^'.$this->attributes['format'].'$/', $value)===1;
    }

    public function db_column_name()
    {
        return $this->db_column;
    }

    // mutators for 'format' attribute
    public function getFormatAttribute($value)
    {
        foreach (self::$PredefinedFormats as $name => $pattern) {
            if ($pattern===$value) {
                return $name;
            }
        }
        return $value;
    }

    /**
     * Format a value string as an array for select boxes and checkboxes.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.4]
     * @return Array
     */
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
    public function formatFieldValuesAsArray()
    {
        $arr = preg_split("/\\r\\n|\\r|\\n/", $this->field_values);

        $result[''] = 'Select '.strtolower($this->format);

        for ($x = 0; $x < count($arr); $x++) {
            $arr_parts = explode('|', $arr[$x]);
            if ($arr_parts[0]!='') {
                if (key_exists('1', $arr_parts)) {
                    $result[$arr_parts[0]] = $arr_parts[1];
                } else {
                    $result[$arr_parts[0]] = $arr_parts[0];
                }
            }
        }


        return $result;
    }

    public function isFieldDecryptable($string)
    {
        if (($this->field_encrypted=='1') && ($string!='')) {
            return true;
        }
        return false;
    }


    public function convertUnicodeDbSlug($original = null)
    {
        $name = $original ? $original : $this->name;
        $id = $this->id ? $this->id : 'xx';

        if (!function_exists('transliterator_transliterate')) {
            $long_slug = '_snipeit_' . str_slug(\Patchwork\Utf8::utf8_encode(trim($name)), '_');
        } else {
            $long_slug =  '_snipeit_' . Utf8Slugger::slugify($name, '_');
        }

        return substr($long_slug, 0, 50) . '_' . $id;
    }
}
