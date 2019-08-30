<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Asset;

class AddFirstCounterTotalsToAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This artisan call may take a while
        \Log::info('This could take a while.... ');
        Artisan::call('snipeit:counter-sync');
        $output = Artisan::output();
        \Log::info($output);

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
