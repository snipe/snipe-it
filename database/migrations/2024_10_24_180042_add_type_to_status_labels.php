<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\StatusLabel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('status_labels', function (Blueprint $table) {
            $table->string('status_type')->after('name')->nullable()->default('deployable');
        });

        DB::table('status_labels')->where('pending', 1)->update(['status_type' => 'pending']);
        DB::table('status_labels')->where('archived', 1)->update(['status_type' => 'archived']);
        DB::table('status_labels')->where('deployable', 1)->update(['status_type' => 'deployable']);

        Schema::table('status_labels', function (Blueprint $table) {
            $table->renameColumn('deployable', 'legacy_deployable');
        });

        Schema::table('status_labels', function (Blueprint $table) {
            $table->renameColumn('pending', 'legacy_pending');
        });

        Schema::table('status_labels', function (Blueprint $table) {
            $table->renameColumn('archived', 'legacy_archived');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_labels', function (Blueprint $table) {
            $table->dropColumn('status_type');

            Schema::table('status_labels', function (Blueprint $table) {
                $table->renameColumn('legacy_deployable', 'deployable');
            });

            Schema::table('status_labels', function (Blueprint $table) {
                $table->renameColumn('legacy_pending', 'pending');
            });

            Schema::table('status_labels', function (Blueprint $table) {
                $table->renameColumn('legacy_archived', 'archived');
            });


        });
    }
};
