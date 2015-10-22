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
		DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');


		//
		//create empty 'default' fieldset'
		//$f1=Fieldset::create([name => "Default Asset"]);
		$f2=new CustomFieldset(['name' => "Asset with MAC Address"]);
		if(!$f2->save()) {
			throw new Exception("couldn't save customfieldset");
		}
		$macid=DB::table('custom_fields')->insertGetId([
			'name' => "MAC Address",
			'format' => CustomField::$PredefinedFormats['MAC'],
			'element'=>'text']);
		if(!$macid) {
			throw new Exception("Can't save MAC Custom field: $macid");
		}
		
		$f2->fields()->attach($macid,['required' => false, 'order' => 1]);
		//$f2->push();
		Model::where(["show_mac_address" => true])->update(["fieldset_id"=>$f2->id]);
		//up to *HERE* works just fine
		print "THIS IS FINE!";
		// $ans2=Schema::table("assets",function (Blueprint $table) {
		// 	$table->renameColumn('mac_address','_snipeit_mac_address');
		// });
		DB::statement("ALTER TABLE assets CHANGE mac_address _snipeit_mac_address varchar(255)");
		// print "NOTHING WORKS";
		// if(!$ans2) {
		// 	throw new Exception("Couldn't rename mac_address collumn in Assets table");
		// }
		$ans=Schema::table("models",function (Blueprint $table) {
			$table->renameColumn('show_mac_address','deprecated_mac_address');
		});
		print "Does this even ahppen";
		// if(!$ans) {
		// 	throw new Exception("couldn't rename show_mac_address column in Models table");
		// }
		// $shit=Schema::table("assets",function (Blueprint $table) {
		// 	$table->renmaeColmnu("fuck you you fucking piece of shit","die in a fucking fire you asshole");
		// });
		// print "seriously";
		// if(!$shit) {
		// 	throw new Exception("something taht should've failed failed. Good.");
		// }
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
		DB::statement("ALTER TABLE assets CHANGE _snipeit_mac_address mac_address varchar(255)");
		// Schema::table("assets",function (Blueprint $table) {
		// 	$table->renameColumn('_snipeit_mac_address','mac_address');
		// });
	}

}
