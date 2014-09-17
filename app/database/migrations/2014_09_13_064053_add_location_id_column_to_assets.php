<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationIdColumnToAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assets', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->smallInteger('location_id')->default(1);
                    $table->tinyInteger('strict_assignment')->default(1);
		});
                
                //Set the initial values to 1 for all existing records
                DB::table('assets')->whereNull('location_id')->update(array('location_id' => 1));                
                DB::table('assets')->whereNull('strict_assignment')->update(array('strict_assignment' => 1));
                
                Schema::table('licenses', function(Blueprint $table)
		{
		// Add location_id to licenses table
                    $table->smallInteger('location_id')->default(1);
                    $table->tinyInteger('strict_assignment')->default(1);
		});
                
                //Set the initial values to 1 for all existing records
                DB::table('licenses')->whereNull('location_id')->update(array('location_id' => 1));                
                DB::table('licenses')->whereNull('strict_assignment')->update(array('strict_assignment' => 1));
                
                Schema::table('service_agreements', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->smallInteger('location_id')->default(1);
                    $table->tinyInteger('strict_assignment')->default(1);
		});
                
                //Set the initial values to 1 for all existing records
                DB::table('service_agreements')->whereNull('location_id')->update(array('location_id' => 1));                
                DB::table('service_agreements')->whereNull('strict_assignment')->update(array('strict_assignment' => 1));

                // Add the multiplelogon setting
                Schema::table('settings', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->boolean('multiplelogons')->default(0);
		});
                
                // Add notes to location 
                Schema::table('locations', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->text('notes')->nullable();
		});
                
        }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assets', function(Blueprint $table)
		{
		// Remove location_id from assets
                    $table->dropColumn('location_id');
                    $table->dropColumn('strict_assignment');                    
		});
                
                Schema::table('licenses', function(Blueprint $table)
		{
		// Remove location_id from assets
                    $table->dropColumn('location_id');
                    $table->dropColumn('strict_assignment');                    
		});
                
                Schema::table('service_agreements', function(Blueprint $table)
		{
		// Remove location_id from assets
                    $table->dropColumn('location_id');
                    $table->dropColumn('strict_assignment');                    
		});
                
                // Remove the multiplelogon setting
                Schema::table('settings', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->dropColumn('multiplelogons');
		});
                
                // Remove notes to location 
                Schema::table('locations', function(Blueprint $table)
		{
		// Add location_id to assets table
                    $table->dropColumn('notes');
		});
	}

}
