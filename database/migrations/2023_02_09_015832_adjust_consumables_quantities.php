<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Consumable;

class AdjustConsumablesQuantities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $consumables_checkedout = DB::table('consumables_users')->select('consumable_id', DB::raw('count(*) as total_checkedout'))->groupBy('consumable_id')->get();

        foreach ($consumables_checkedout as $consumable){
            $consumable_qty = Consumable::select('qty')->where(['id' => $consumable->consumable_id])->value('qty');
            $total = (int) $consumable_qty - (int) $consumable->total_checkedout;

            // Control that the $total is never negative 
            if ($total < 0){
                $total = 0;
            }

            Consumable::where('id', $consumable->consumable_id)->update(['qty' => $total]);
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
