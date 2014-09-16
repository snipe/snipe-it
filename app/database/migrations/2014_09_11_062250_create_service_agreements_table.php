<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceAgreementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            // Add the service agreements table
		Schema::create('service_agreements', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name');
                        $table->string('contract_number')->nullable();
                        $table->string('management_url')->nullable();
                        $table->string('registered_to')->nullable();  
                        $table->integer('user_id');
                        $table->integer('term_months')->default(0);
                        $table->integer('supplier_id')->nullable();
                        $table->integer('service_agreement_type_id');
                        $table->date('purchase_date')->nullable();
                        $table->decimal('purchase_cost', 8, 2)->nullable();
                        $table->text('notes');
			$table->timestamps();
                        $table->softDeletes();
		});
            
            // Add the service agreements type table
                Schema::create('service_agreement_type', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name');
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
		Schema::drop('service_agreements');
                Schema::drop('service_agreement_type');
	}

}
