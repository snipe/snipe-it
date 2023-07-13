<?php

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
        $customEolAssets = DB::table('assets')->whereNotNull('eol_explicit')->get();
        foreach ($customEolAssets as $asset) {
            DB::table('assets')->where('id', $asset->id)->update(['asset_eol_date' => $asset->eol_explicit]);
        }
        
        $assets = DB::table('assets')->whereNull('asset_eol_date')->get();
        foreach ($assets as $asset) {
            $model = DB::table('models')->where('id', $asset->model_id)->first();
            if ($model) {
                $eol = $model->eol;
                if ($eol) {
                    $asset_eol_date = date('Y-m-d', strtotime($asset->asset_purchase_date . ' + ' . $eol . ' months'));
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
