<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToConsumablesUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumables_users', function ($table) {
            $table->integer('company_id')->nullable();
        });

        // Populate the table with the correspondent company id
        $results = DB::table('users')->select('company_id', 'id')->get();
        foreach($results as $result){
            $update = DB::update('update '.DB::getTablePrefix().'consumables_users set company_id=? where user_id=?', [$result->company_id, $result->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables_users', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
