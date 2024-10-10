<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
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
        foreach (self::$tables as $table_name) {
            DB::table($table_name)->select(['id', 'deprecated_order_number'])->whereNotNull('deprecated_order_number')->orderBy('id')->chunk(100, function (Collection $order_numbers) use ($order_hash, $table_name) {
                foreach ($order_numbers as $order) {
                    if (!array_key_exists($order->deprecated_order_number, $order_hash)) {
                        $order_record = Order::create(['order_number' => $order->deprecated_order_number]);
                        $order_hash[$order->deprecated_order_number] = $order_record->id;
                    }
                    DB::table($table_name)->where('id', $order->id)->update(['order_id' => $order_hash[$order->deprecated_order_number]]);
                }
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
