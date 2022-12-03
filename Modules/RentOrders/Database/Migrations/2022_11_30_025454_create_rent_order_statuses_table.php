<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RentOrders\Entities\RentOrderStatus;

class CreateRentOrderStatusesTable extends Migration
{
    const statuses = [
        "Pending",
        "Delivered",
        "Canceled",
        "Returned"
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_orders_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name", "25");
        });

        Schema::table('rent_orders', function (Blueprint $table) {
            $table->unsignedBigInteger("status");
            $table->foreign("status")->references("id")->on("rent_orders_statuses");
        });

        foreach ($this::statuses as $statusName){
            $status = RentOrderStatus::create(["name"=>$statusName]);
            $status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_orders', function (Blueprint $table) {
            $table->dropForeign("rent_orders_status_foreign");
            $table->dropColumn("status");
        });
        Schema::dropIfExists('rent_orders_statuses');
    }
}
