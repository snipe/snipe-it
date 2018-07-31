<?php

use App\Models\LicenseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Category;

class AddUpdateLicenseCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create a new software category and assign all of the existing licenses to it
        $category = new Category;
        $category->name = 'Misc Software';
        $category->category_type = 'license';

        if ($category->save()) {
            LicenseModel::whereNull('category_id')->withTrashed()
                ->update(['category_id' => $category->id]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        App\Models\Category::where('name', 'Misc Software')->forceDelete();

        LicenseModel::whereNotNull('category_id')
            ->update(['category_id' => null]);
    }
}
