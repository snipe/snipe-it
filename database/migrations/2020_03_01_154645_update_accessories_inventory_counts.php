<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAccessoriesInventoryCounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // updates reconciles for current in_stock
        DB::insert('INSERT INTO `inventory_adjustments` (item_type, item_id, stock_location_id, qty, from_state, to_state, occurred_at, user_id, created_at, updated_at)
        SELECT
            "App\\\Models\\\Accessory" AS "item_type",
            id AS "item_id",
            IFNULL(location_id, 0) AS "stock_location_id",
            IFNULL(qty, 0) AS qty,
            "none" as from_state,
            "in_stock" AS to_state,
            NOW(3) AS occurred_at,
            user_id AS user_id,
            NOW() AS created_at,
            NOW() AS updated_at
        FROM
            `accessories`
            HAVING qty > 0');

        // update reconcile for current checked_out
        DB::insert('INSERT INTO `inventory_adjustments` (item_type, item_id, stock_location_id, qty, from_state, to_state, occurred_at, user_id, created_at, updated_at)
        SELECT "App\\\Models\\\Accessory" as "item_type", id as "item_id", ifnull(location_id,0) as "stock_location_id", ifnull(sum_accessories,0) as qty, "in_stock" as from_state, "checked_out" as to_state, NOW(3) as occurred_at, user_id as user_id, NOW() as created_at, NOW() as updated_at
                FROM `accessories`
                LEFT JOIN (
                  SELECT `accessory_id`, count(id) as sum_accessories
                  FROM `accessories_users`
                  GROUP BY accessory_id
                ) as sum on sum.accessory_id = `accessories`.`id`
                HAVING qty > 0
        ');

        // updates counts for in_stock
        DB::insert('INSERT INTO `inventory_counts` (item_type, item_id, stock_location_id, qty, state, occurred_at, created_at, updated_at)
        SELECT "App\\\Models\\\Accessory" as "item_type", id as "item_id", ifnull(location_id,0) as "stock_location_id", (ifnull(qty,0) - ifnull(sum_checkout,0)), "in_stock" as state, NOW(3) as occurred_at, NOW() as created_at, NOW() as updated_at
        FROM `accessories`
        LEFT JOIN (
            SELECT `accessory_id`, count(id) as sum_checkout
            FROM `accessories_users`
            GROUP BY accessory_id
        ) as sum on sum.accessory_id = `accessories`.`id`');

        // update counts for checked_out
        DB::insert('INSERT INTO `inventory_counts` (item_type, item_id, stock_location_id, qty, state, occurred_at, created_at, updated_at)
        SELECT "App\\\Models\\\Accessory" as "item_type", id as "item_id", ifnull(location_id,0) as "stock_location_id", ifnull(sum_accessories,0) as qty, "checked_out" as state, NOW(3) as occurred_at, NOW() as created_at, NOW() as updated_at
        FROM `accessories`
        LEFT JOIN (
          SELECT `accessory_id`, count(id) as sum_accessories
          FROM `accessories_users`
          GROUP BY accessory_id
        ) as sum on sum.accessory_id = `accessories`.`id`
        ');    }

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
