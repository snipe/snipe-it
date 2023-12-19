<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixLanguageDirs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Pull the autoglossonym array from the localizations translation file
        foreach (trans('localizations.languages') as $abbr) {
            $select .= '<option value="'.$abbr.'"'.(($selected == $abbr) ? ' selected="selected" role="option" aria-selected="true"' : ' aria-selected="false"').'>'.$locale.'</option> ';
        }

        Schema::table('models', function (Blueprint $table) {
            $table->integer('min_amt')->nullable()->change();
        });


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
