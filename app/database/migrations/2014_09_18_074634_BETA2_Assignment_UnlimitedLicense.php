<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BETA2AssignmentUnlimitedLicense extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            // Add assignment types table
		Schema::create('assignment_types', function(Blueprint $table)
		{
                    $table->increments('id');
                    $table->string('name');                          
                    $table->integer('assignment_definition_id');
                    $table->text('notes');
                    $table->integer('user_id');
                    $table->timestamps();
		});

            // Add assignment types table
                Schema::create('assignment_definitions', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name'); 
                        $table->string('applies_to'); 
                        $table->string('assigned_object'); 
			$table->timestamps();
		});
                
                Schema::table('licenses', function(Blueprint $table)
		{
		// Add family_id to licenses table
                    $table->integer('assignment_type_id')->nullable();
		});
                
                Schema::table('assets', function(Blueprint $table)
		{
		// Add family_id to licenses table
                    $table->integer('assignment_type_id')->nullable();
		});
                
                // Seed the new tables
                //Eloquent::unguard();
                //$seeder = new Seeder();
                //$seeder->call('AssignmentTypesSeeder');
                //$seeder->call('AssignmentDefinitionsSeeder');   
                
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assignment_types');
		Schema::drop('assignment_definitions');
                
                Schema::table('assets', function(Blueprint $table)
		{
		// Remove the family_id column
                    $table->dropColumn('assignment_type_id');
		});
                
                Schema::table('licenses', function(Blueprint $table)
		{
		// Remove the family_id column
                    $table->dropColumn('assignment_type_id');
		});
	}

}
