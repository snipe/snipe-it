<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseOrderDateWarrantyDatePurchaseCostColumnToSerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serials', function (Blueprint $table) {
            $table->string('purchase_order')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->unsignedInteger('supplier_id')->unsigned()->nullable();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serials', function (Blueprint $table) {
            // Make sure the column exists before trying to drop it
            if (Schema::hasColumn('serials', 'purchase_order')) {
                $table->dropColumn('purchase_order');
            }

            if (Schema::hasColumn('serials', 'purchase_date')) {
                $table->dropColumn('purchase_date');
            }

            if (Schema::hasColumn('serials', 'warranty_date')) {
                $table->dropColumn('warranty_date');
            }

            if (Schema::hasColumn('serials', 'purchase_cost')) {
                $table->dropColumn('purchase_cost');
            }

            if (Schema::hasColumn('serials', 'supplier_id')) {
                $table->dropColumn('supplier_id');
                $table->dropForeign('serials_supplier_id_foreign');
            }
        });
    }
}
