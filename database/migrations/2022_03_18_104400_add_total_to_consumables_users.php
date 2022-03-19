<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalToConsumablesUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumables_users', function (Blueprint $table) {
            $table->integer('totalnum')->default(1);
            $table->text('checkoutnote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consumables_users', function (Blueprint $table) {
            if (Schema::hasColumn('consumables_users', 'totalnum')) {
                $table->dropColumn('totalnum');
            }
            if (Schema::hasColumn('consumables_users', 'checkoutnote')) {
                $table->dropColumn('checkoutnote');
            }
        });
    }
}
