<?php

use App\Models\Asset;
use Carbon\CarbonImmutable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->boolean('eol_explicit')->default(false)->after('asset_eol_date');
        });


        // Update the eol_explicit column with the value from asset_eol_date if it exists and is different from the calculated value
        Asset::whereNotNull('asset_eol_date')->chunk(100, function ($assetsWithEolDates) {
            foreach ($assetsWithEolDates as $asset) {
                if ($asset->asset_eol_date && $asset->purchase_date) {
                    $months = CarbonImmutable::parse($asset->asset_eol_date)->diffInMonths($asset->purchase_date);
                    if ($asset->model->eol) {
                        if ($months != $asset->model->eol) {
                            $asset->update(['eol_explicit' => true]);
                        }
                    } else {
                        $asset->update(['eol_explicit' => true]);
                    }
                }
            }
        });

        // Update the asset_eol_date column with the calculated value if it doesn't exist 
        Asset::whereNull('asset_eol_date')->chunk(100, function ($assets) {
            foreach ($assets as $asset) {
                $model = Asset::find($asset->id)->model;
                if (!empty($model->eol)) {
                    $asset_eol_date = CarbonImmutable::parse($asset->purchase_date)->addMonths($model->eol)->format('Y-m-d');
                    $asset->update(['asset_eol_date' => $asset_eol_date]);
                }
            }
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
                $table->dropColumn('eol_explicit');
        });
    }
}
