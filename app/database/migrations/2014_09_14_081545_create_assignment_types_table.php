<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignment_types', function(Blueprint $table)
		{
                    
                    $table->string('name');  
                    $table->increments('id');                        
                    $table->string('applies_to');
                    $table->string('assignable_to');
                    $table->text('notes');
                    $table->integer('user_id');
                    $table->integer('assignment_definition_id');
                    $table->timestamps();
		});
                               
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
                
                DB::statement('ALTER TABLE models MODIFY column notes text NULL');
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
