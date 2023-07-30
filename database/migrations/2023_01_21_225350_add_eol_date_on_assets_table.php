<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Asset;
use App\Models\AssetModel;

class AddEolDateOnAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'asset_eol_date')) {
                $table->date('asset_eol_date')->after('purchase_date')->nullable()->default(null);
            }
        });

        // Chunk the model query to get the models that do have an EOL date
        AssetModel::whereNotNull('eol')->chunk(10, function ($models) {
            foreach ($models as $model) {
                foreach ($model->assets as $asset) {

                    if ($asset->purchase_date!='') {
                        $asset->asset_eol_date = $asset->present()->eol_date();
                        $asset->save();
                    }

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
            if (Schema::hasColumn('assets', 'asset_eol_date')) {
                $table->dropColumn('asset_eol_date');
            }
        });
    }
}
