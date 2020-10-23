<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Asset;

class FixZeroValuesForLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $assets = Asset::where('location_id', '=', '0')->orWhere('rtd_location_id', '=', '0')->get();
        $users = User::where('location_id', '=', '0')->get();

        foreach ($assets as $asset) {

            if ($asset->location_id == '0') {
                $asset->location_id = '';
            }

            if ($asset->rtd_location_id == '0') {
                $asset->rtd_location_id = '';
            }

            $asset->save();

        }

        foreach ($users as $user) {
            if ($user->location_id == '0') {
                $user->location_id = '';
            }

            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
