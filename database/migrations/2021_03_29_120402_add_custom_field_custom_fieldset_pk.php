<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldCustomFieldsetPk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_field_custom_fieldset', function (Blueprint $table) {
            $table->primary(['custom_field_id', 'custom_fieldset_id'], 'custom_field_custom_fieldset_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_field_custom_fieldset', function (Blueprint $table) {
            $table->dropPrimary('custom_field_custom_fieldset_primary');
        });
    }
}
