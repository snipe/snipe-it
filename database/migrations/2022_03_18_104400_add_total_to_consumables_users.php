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
            $table->integer('checkout_qty')->default(1);
            $table->text('checkout_note')->nullable();
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
            if (Schema::hasColumn('consumables_users', 'checkout_qty')) {
                $table->dropColumn('checkout_qty');
            }
            if (Schema::hasColumn('consumables_users', 'checkout_note')) {
                $table->dropColumn('checkout_note');
            }
        });
    }
}
