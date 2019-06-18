<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use App\Models\CustomField;
use Illuminate\Database\Schema\Blueprint;

/**
 * Fixes issue #2551 where columns got donked if the field name in non-ascii
 * format.
 *
 * The only time this is ever called is in the
 * 2017_01_25_063357_fix_utf8_custom_field_column_names.php migration
 * as a one-time fix.
 *
 * @author [A. Gianotto] [<snipe@snipe.net>]
 * @since [v4.0]
 * @return Array
 */

function updateLegacyColumnName($customfield) {

    $name_to_db_name = CustomField::name_to_db_name($customfield->name);
    //\Log::debug('Trying to rename '.$name_to_db_name." to ".$customfield->convertUnicodeDbSlug()."...\n");

    if (Schema::hasColumn(CustomField::$table_name, $name_to_db_name)) {

        return Schema::table(CustomField::$table_name,
            function ($table)  use ($name_to_db_name, $customfield) {
                $table->renameColumn($name_to_db_name, $customfield->convertUnicodeDbSlug());
            }
        );

    } else {
        //\Log::debug('Legacy DB column '.$name_to_db_name.' was not found on the assets table.');
    }

}




class FixUtf8CustomFieldColumnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        if (!Schema::hasColumn('custom_fields', 'db_column')) {
            Schema::table('custom_fields', function ($table) {
                $table->string('db_column')->nullable();
                $table->text('help_text')->nullable();
            });
        }

        foreach(CustomField::all() as $field) {

            $db_column = $field->convertUnicodeDbSlug();

            DB::table('custom_fields')
                ->where('id', $field->id)
                ->update(['db_column' => $db_column]);

            // change the name of the column
            updateLegacyColumnName($field);


        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_fields', function ($table) {
            $table->dropColumn('db_column');
            $table->dropColumn('help_text');
        });
    }

}
