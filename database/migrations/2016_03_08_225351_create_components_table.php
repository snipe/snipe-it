<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //
     Schema::create('components', function ($table) {
        $table->increments('id');
        $table->string('name')->nullable()->default(NULL);
        $table->integer('category_id')->nullable()->default(NULL);
        $table->integer('location_id')->nullable()->default(NULL);
        $table->integer('company_id')->nullable()->default(NULL);
        $table->integer('user_id')->nullable()->default(NULL);
        $table->integer('total_qty')->default(1);
        $table->integer('order_number')->nullable()->default(NULL);
        $table->date('purchase_date')->nullable()->default(NULL);
        $table->decimal('purchase_cost', 13,4)->nullable()->default(NULL);
        $table->timestamps();
        $table->softDeletes();
        $table->engine = 'InnoDB';
      });

        Schema::table('asset_logs', function ($table) {
      $table->integer('component_id')->nullable()->default(NULL);
    });

    Schema::create('components_assets', function ($table) {
        $table->increments('id');
        $table->integer('user_id')->nullable()->default(NULL);
        $table->integer('assigned_qty')->nullable()->default(1);
        $table->integer('component_id')->nullable()->default(NULL);
        $table->integer('asset_id')->nullable()->default(NULL);
        $table->timestamps();
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
    Schema::dropIfExists('components');
    Schema::dropIfExists('components_assets');

    Schema::table('asset_logs', function ($table) {
      $table->dropColumn('component_id');
    });


  }

}
