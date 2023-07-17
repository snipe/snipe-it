<?php

use App\Models\Asset;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
      
       
        // Update the eol_explicit column with the value from asset_eol_date if it exists and is different from the calculated value
        $assetsWithEolDates = Asset::whereNotNull('asset_eol_date')->get();
        foreach($assetsWithEolDates as $asset) {
            if($asset->asset_eol_date && $asset->asset_purchase_date) {
                $months = Carbon::parse($asset->asset_eol_date)->diffInMonths($asset->asset_purchase_date);
                if($months != $asset->model->eol) {
                    DB::table('assets')->find($asset->id)->update(['eol_explicit' => $asset->asset_eol_date]);
                }
            }
        }

        // Update the asset_eol_date column with the calculated value if it doesn't exist 
        $assets = DB::table('assets')->whereNull('asset_eol_date')->get();
        foreach ($assets as $asset) {
            $model = Asset::find($asset->id)->model;
            if ($model) {
                $eol = $model->eol;
                if ($eol) {
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
