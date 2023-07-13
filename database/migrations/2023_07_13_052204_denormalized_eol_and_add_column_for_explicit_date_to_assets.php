<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DenormalizedEolAndAddColumnForExplicitDateToAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->date('eol_explicit')->after('asset_eol_date')->nullable();
        });
       
        // this is really just a scratch pad for the next step... but it might actually work? 
        // need to check out some things before trying it out, specifically whether or not 
        // asset_eol_date is only actually set when it's custom
        $explicitEolAssets = DB::table('assets')->whereNotNull('eol_explicit')->get();
        //maybe try if ->diffInMonths($asset->eol_explicit) or something to determine explicit date
        foreach ($explicitEolAssets as $asset) {
            DB::table('assets')->where('id', $asset->id)->update(['asset_eol_date' => $asset->eol_explicit]);
        }
        
        $assets = DB::table('assets')->whereNull('asset_eol_date')->get();
        foreach ($assets as $asset) {
            $model = DB::table('models')->where('id', $asset->model_id)->first();
            if ($model) {
                $eol = $model->eol;
                if ($eol) {
                   //getting rid of the weird date($asset->asset_purchase_date, strtotime('+'.$eol.' months') thing because it was weird
                    $asset_eol_date = Carbon::parse($asset->asset_purchase_date)->addMonths($eol)->format('Y-m-d');
                    DB::table('assets')->where('id', $asset->id)->update(['asset_eol_date' => $asset_eol_date]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
}
