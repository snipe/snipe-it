<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Accessory;

class MoveAccessoryCheckoutNoteToJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('accessory_checkout', function (Blueprint $table) {
//            $table->string('note')->nullable(true)->default(null);
//        });

        // Loop through the checked out accessories, find their related action_log entry, and copy over the note
        // to the newly created note field


        $accessories = Accessory::get();
        $count = 0;

        foreach ($accessories as $accessory) {
            $count++;

            foreach ($accessory->users as $join_log) {

                \Log::debug('Looking for accessories_users that match '. $join_log->created_at);

                $log_entries = $accessory
                    ->assetlog()
                    ->whereNotNull('note')
                    ->where('created_at', '=',$join_log->created_at)
                    ->where('action_type', '=', 'checkout')
                    ->orderBy('created_at', 'DESC')
                    ->take('1');


                \Log::debug($accessory->toSql());

                $log_entries->get();

                \Log::debug($count. '. Looking for action_logs that match '. $join_log->created_at);

                foreach ($log_entries as $log_entry) {
                    \Log::debug($log_entries->count().' action_logs that match');

                    \Log::debug($count. '. Checkout date in asset log: '.$log_entry->created_at.' against accessories_users: '.$join_log->created_at);

                    if ($log_entry->created_at == $join_log->created_at) {
                        \Log::debug($count. '. Note for '.$accessory->name.' checked out on '.$log_entry->created_at.' to '.$log_entry->target_id.' is '.$log_entry->note);
                    } else {
                        \Log::debug('No match');

                    }
                }

            }



        }

        die();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessory_checkout', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
