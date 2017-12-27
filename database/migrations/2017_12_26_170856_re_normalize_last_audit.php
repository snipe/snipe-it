<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReNormalizeLastAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasColumn('assets', 'last_audit_date')) {
            // Grab the latest info from the Actionlog table where the action is 'audit'
            $audits = Actionlog::selectRaw('MAX(created_at) AS created_at, item_id')
                ->where('action_type', 'audit')
                ->where('item_type', Asset::class)
                ->groupBy('item_id')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($audits) {
                foreach ($audits as $audit) {
                    $assets = Asset::where('id', $audit->item_id)->first();
                    $assets->last_audit_date = $audit->created_at;
                    $assets->unsetEventDispatcher();
                    $assets->save();
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
        //
    }
}
