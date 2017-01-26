<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use App\Models\CustomField;

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

        if (Schema::hasColumn(CustomField::$table_name, $name_to_db_name)) {

            return Schema::table(CustomField::$table_name,
                function ($table)  use ($name_to_db_name, $customfield) {
                    $table->renameColumn($name_to_db_name, $customfield->convertUnicodeDbSlug());
                }
            );

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

        foreach(CustomField::all() as $field) {
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
        //
    }

}
