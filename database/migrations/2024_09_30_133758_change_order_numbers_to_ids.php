<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    static $tables = [
        'assets',
        'components',
        'licenses',
        'accessories',
        'consumables'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $order_hash = [];
        foreach(self::$tables as $table_name) {
            Schema::table($table_name, function (Blueprint $table) use ($table_name,$order_hash) {
                //
                $table->integer('order_id')->nullable()->default(null)->after('order_number');
                $table->renameColumn('order_number', 'deprecated_order_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach(self::$tables as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                //
                $table->dropColumn('order_id');
                $table->renameColumn('deprecated_order_number','order_number');
            });
        }
    }
};
