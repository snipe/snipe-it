<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateMacAddress extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		//create empty 'default' fieldset'
		//$f1=Fieldset::create([name => "Default Asset"]);
		$f2=new CustomFieldset(['name' => "Asset with MAC Address"]);
		if(!$f2->save()) {
			throw new Exception("couldn't save customfieldset");
		}
		$mac=new CustomField(['name' => "MAC Address",'format' =>'MAC','element'=>'text']);
		if(!$mac->save()) {
			throw new Exception("Mac ID: $macid");
		}
		
		$f2->fields()->save($mac,['required' => false, 'order' => 1]);
		//$f2->push();

		Model::where(["show_mac_address" => true])->update(["fieldset_id"=>$f2->id]);
		Schema::table("models",function (Blueprint $table) {
			$table->renameColumn('show_mac_address','deprecated_mac_address');
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
		$f=CustomFieldset::where(["name" => "Asset with MAC Address"])->first();
		$f->fields()->delete();
		$f->delete();
		Schema::table("models",function(Blueprint $table) {
			$table->renameColumn("deprecated_mac_address","show_mac_address");
		});
	}

}
