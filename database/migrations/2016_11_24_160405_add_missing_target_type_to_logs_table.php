<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddMissingTargetTypeToLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_logs', function (Blueprint $table) {
            // Get list of action logs with a target id but not a target type.  This fixes missing target_type in accept_asset
            $logs = DB::table('action_logs')->where('target_type', null)->where(function($query) {
                $query->where('action_type', 'accepted')
                ->orWHere('action_type', 'declined');
            })->update(['target_type'=> 'App\Models\User']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_logs', function (Blueprint $table) {
            //
        });
    }
}
