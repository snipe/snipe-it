<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataUpdateForCountryInventoryStatuslabelsDefaultsV0320 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            $seeder = new Seeder();
            
            //Populate countries table
            $seeder->call('CountriesSeeder');
            //Populate asset_inventory_status table
            $seeder->call('InventoryStatesSeeder');
            //Populate software families
            $seeder->call('FamiliesSeeder');
            //Populate default settings
            $seeder->call('DefaultsSeeder');
            //Populate NEW asset_status_label items - NOT NEEDED, adds duplicates
            //$seeder->call('StatuslabelsSeeder');
              
            //Update the asset status_ids to match the new 'table' values
            //DB::table('assets')->whereNull('status_id')->update(array('status_id' => 1));
            //DB::table('assets')->where('status_id', 0)->update(array('status_id' => 2));
            Eloquent::unguard();
    
            $oldStatuslabels = Statuslabel::all();
            $newStatusLabels = new \Illuminate\Database\Eloquent\Collection();

            //create the 3 new status
            $inPrep = new Statuslabel();
            $inPrep->id = 1;
            $inPrep->name = 'In Preparations';
            $inPrep->inventory_state_id = 1;
            $inPrep->user_id = 1;

            $newStatusLabels->add($inPrep);

            $ready = new Statuslabel();
            $ready->id = 2;
            $ready->name = 'Ready to Deploy';
            $ready->inventory_state_id = 2;
            $ready->user_id = 1;

            $newStatusLabels->add($ready);

            $assigned = new Statuslabel();
            $assigned->id = 3;
            $assigned->name = 'Assigned In Use';
            $assigned->inventory_state_id = 3;
            $assigned->user_id = 1;  

            $newStatusLabels->add($assigned);  

            //clear the table
            DB::table('status_labels')->truncate();

            //save the new values
            foreach($newStatusLabels as $label)
            {
                $label->save();
            }

            //add the old values back in with updated ids
            foreach($oldStatuslabels->reverse() as $label)
            {
                $nextLabel = new Statuslabel();

                //update id by +3
                $nextLabel->id = ($label->id + 3);        
                $nextLabel->inventory_state_id = 4;
                
                //Add "deleted" text if the status was previously soft deleted
                if ($label->deleted_at) {
                    $nextLabel->name = $label->name.' (DELETED)';                                    
                } else {
                    $nextLabel->name = $label->name; 
                }
                   
                $nextLabel->user_id = $label->user_id;
                $nextLabel->created_at = $label->created_at;
                $nextLabel->deleted_at = $label->deleted_at;
                $nextLabel->updated_at = $label->updated_at;

                $nextLabel->save();

                //update the associated assets
                $affectedRows = Asset::where('status_id', '=', $label->id)->update(array('status_id' => $nextLabel->id));       

            }

            //update rows that had status id of 0 or null    
            $affectedRows = Asset::where('status_id', '=', 0)->where('assigned_to', '>', 0)->update(array('status_id' => 3));
            $affectedRows = Asset::where('status_id', '=', 0)->update(array('status_id' => 2));
            $affectedRows = Asset::where('status_id', '=', null)->update(array('status_id' => 1));

            
            //Set license_seats to NULL -> this field is deprecated, will be replaced by new assignment logic in next version
            DB::table('license_seats')->whereNotNull('assigned_to')->update(array('assigned_to' => NULL));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Eloquent::unguard();
            
            //revert rows that had status id of 1,2,3 back to     
            $affectedRows = Asset::where('status_id', '=', 3)->update(array('status_id' => 0));
            $affectedRows = Asset::where('status_id', '=', 2)->update(array('status_id' => 0));
            $affectedRows = Asset::where('status_id', '=', 1)->update(array('status_id' => null));
            
            //revert asset status labels to old values
            $oldStatuslabels = Statuslabel::all();
            DB::table('status_labels')->truncate();

            foreach($oldStatuslabels as $label)
            {
                if($label->id > 3)
                {            
                    $nextLabel = new Statuslabel();

                    //update id by -3
                    $nextLabel->id = ($label->id - 3);        
                    $nextLabel->inventory_state_id = 4;

                    //Remove "deleted" text if the status was previously soft deleted
                    if ($label->deleted_at) {
                        $nextLabel->name = str_replace(' (DELETED)','',$label->name);                                    
                    } else {
                        $nextLabel->name = $label->name; 
                    }
                       
                    $nextLabel->name = $label->name;
                    $nextLabel->user_id = $label->user_id;
                    $nextLabel->created_at = $label->created_at;
                    $nextLabel->deleted_at = $label->deleted_at;
                    $nextLabel->updated_at = $label->updated_at;

                    $nextLabel->save();

                    //update the associated assets
                    $affectedRows = Asset::where('status_id', '=', $label->id)->update(array('status_id' => $nextLabel->id));
                }

            }

            // Revert the asset status_ids to the old assumed values
            //DB::table('assets')->where('status_id', 1)->update(array('status_id' => NULL));
            //DB::table('assets')->where('status_id', 2)->update(array('status_id' => 0));
            
            //Revert asset_status inventory_status to NULL
            
	}
        
        

}
