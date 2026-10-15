<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Repair action_logs rows whose item_type is 'App\Http\Controllers\License'.
 *
 * Between 2016 and 2018, UsersController::postBulkSave() lived in the
 * App\Http\Controllers namespace and wrote `License::class` without
 * importing App\Models\License, so PHP resolved it to the non-existent
 * App\Http\Controllers\License. Eager-loading the `item` morph over
 * those rows throws "Class not found" (e.g. the activity report CSV
 * export). The code was fixed when the method moved to
 * Users\BulkUsersController, but the logged rows were never repaired.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('action_logs')
            ->where('item_type', 'App\Http\Controllers\License')
            ->update(['item_type' => 'App\Models\License']);
    }

    public function down(): void
    {
        //
    }
};
