<?php
namespace App\Models;

use App\Enums\States;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use DB;



class InventoryCount extends Model
{
    protected $dates = ['occurred_at'];
    protected $table = 'inventory_counts';

    public $rules = array(
        'item_type'         => 'required|string',
        'item_id'           => 'required|integer',
        'state'             => 'required|in:none,in_stock,pending,checked_out,used,waste,lost,ordered_from_supplier,reserved_request',
        'stock_location_id' => 'required|integer',
        'qty'               => 'required|min:1',
        'occurred_at'        => 'required',
    );
    use ValidatingTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_type', 'item_id', 'state','stock_location_id','qty','occurred_at'];

    /**
     * Inventory polymorphic relationship
     */
    public function item()
    {
        return $this->morphTo('item_type');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lastCount($item_type, $item_id, $stock_location_id, $state)
    {
      return InventoryCount::select('s1.id', 's1.item_type', 's1.item_id', 's1.stock_location_id', 's1.state', 's1.occurred_at', 's1.qty')
                                ->from('inventory_counts as s1')
                                ->where('item_type', '=', $item_type)
                                ->where('item_id', '=', $item_id)
                                ->where('stock_location_id', '=', $stock_location_id)
                                ->where('state', '=', $state)
                                ->orderBy('s1.occurred_at', 'DESC')
                                ->limit(1)
                                ->first();
    }


    public function lastCounts($wheres = null)
    {
      $counts = InventoryCount::select('s1.*')
      //select('s1.id', 's1.item_type', 's1.item_id', 's1.stock_location_id', 's1.state', 's1.occurred_at', 's1.qty')
                      ->from('inventory_counts as s1')
                      ->leftJoin('inventory_counts as s2', function($join) {
                        $join->on('s1.item_type', '=', 's2.item_type');
                        $join->on('s1.item_id', '=', 's2.item_id');
                        $join->on('s1.stock_location_id', '=', 's2.stock_location_id');
                        $join->on('s1.state', '=', 's2.state');
                        $join->on('s1.occurred_at', '<', 's2.occurred_at');
                      })
                      ->whereNull('s2.occurred_at');
                      /*
                      ->orderBy('item_type', 'ASC')
                      ->orderBy('item_id', 'ASC')
                      ->orderBy('stock_location_id', 'ASC')
                      ->orderBy('state', 'ASC');
                      */
      
      return $counts;
    }

    public function recentQuantitiesByGroup($group = null, $wheres = null, $states = null)
    {
      // by item_type
      // by item_type, item_id
      // by item_type, item_id, location_id
      // by item_type, item_id, location_id, state
      // by item_type, state
      // by location_id
      // by location_id, state
      // by state
      $sub = $this->lastCounts();

      if (!$group) {
        $group = ['item_type', 'item_id', 'stock_location_id'];
      }
      if (!$wheres || !array_key_exists('state', $wheres)) {
        if (!$wheres) 
          $wheres = [];

        $wheres['state'] = States::$default_view_states;
      }

      // start query
      $query = InventoryCount::query();

      // Add selects based on grouping
      if (in_array('item_type', $group))
        $query->addSelect('item_type');
      if (in_array('item_id', $group))
        $query->addSelect('item_id');
      if (in_array('stock_location_id', $group))
        $query->addSelect('stock_location_id');

      // add quantities sums based on states
      foreach ($wheres['state'] as $key => $value) {
        $query->addSelect(DB::raw("SUM(CASE WHEN `state` = '{$value}' THEN `qty` ELSE 0 END) AS {$value}"));
      }
      $query->addSelect(DB::raw("SUM(`qty`) AS total"));

      // From current actual qantities
      $query->from(DB::raw("({$sub->toSql()}) as sub"));
      //->mergeBindings($sub->getQuery())  // need to merge bindings if there are any?

      // filter based on wheres
      if ($wheres) {
        foreach ($wheres as $key => $value) {
          if (is_array($value)) {
            $query->whereIn('sub.'.$key, $value);
          } else {
            $query->where('sub.'.$key, '=', $value);
          }
        }
      }

      // group query based on group
      $query->groupBy($group);

      return $query;
    }

        //public function recen

    /* another counting option
    SELECT `ic`.`id`, `ic`.`item_type`, `ic`.`item_id`, `ic`.`stock_location_id`, `ic`.`state`, `ic`.`qty`
FROM
(SELECT `item_type`, `item_id`, `stock_location_id`, `state`, max(`occurred_at`) as occurred_at
FROM `inventory_counts`
GROUP BY `item_type`, `item_id`, `stock_location_id`, `state`) as rc
join `inventory_counts` as ic ON
`ic`.`item_type` = `rc`.`item_type`
and `ic`.`item_id` = `rc`.`item_id`
and `ic`.`stock_location_id` = `rc`.`stock_location_id`
and `ic`.`state` = `rc`.`state`
and `ic`.`occurred_at` = `rc`.`occurred_at`
*/

/* by specific item / location
SELECT `ic`.`id`, `ic`.`item_type`, `ic`.`item_id`, `ic`.`stock_location_id`,
	sum(case when `ic`.`state` = 'in_stock' then `ic`.`qty` else 0 end) as In_Stock,
	sum(case when `ic`.`state` = 'checked_out' then `ic`.`qty` else 0 end) as Checked_Out,
	sum(case when `ic`.`state` = 'pending' then `ic`.`qty` else 0 end) as Pending
FROM
(SELECT `item_type`, `item_id`, `stock_location_id`, `state`, max(`occurred_at`) as occurred_at
FROM `inventory_counts`
GROUP BY `item_type`, `item_id`, `stock_location_id`, `state`) as rc
join `inventory_counts` as ic ON
`ic`.`item_type` = `rc`.`item_type`
and `ic`.`item_id` = `rc`.`item_id`
and `ic`.`stock_location_id` = `rc`.`stock_location_id`
and `ic`.`state` = `rc`.`state`
and `ic`.`occurred_at` = `rc`.`occurred_at`
GROUP BY `ic`.`item_type`, `ic`.`item_id`, `ic`.`stock_location_id`, `ic`.`state`
*/

/* By a certain item type_type
select `accessories`.`id`, `accessories`.`name`, quantities.in_stock, quantities.checked_out, quantities.pending
from `accessories`
left join (
 SELECT `ic`.`id`, `ic`.`item_id`,
	sum(case when `ic`.`state` = 'in_stock' then `ic`.`qty` else 0 end) as in_stock,
	sum(case when `ic`.`state` = 'checked_out' then `ic`.`qty` else 0 end) as checked_out,
	sum(case when `ic`.`state` = 'pending' then `ic`.`qty` else 0 end) as pending
FROM
(SELECT `item_id`,`state`, max(`occurred_at`) as occurred_at
FROM `inventory_counts`
where item_type = 'App\\\Models\\\Accessory'
GROUP BY `item_id`, `state`) as rc
join `inventory_counts` as ic
on `ic`.`item_id` = `rc`.`item_id`
and `ic`.`state` = `rc`.`state`
and `ic`.`occurred_at` = `rc`.`occurred_at`
GROUP BY `ic`.`item_id`
) as quantities
on quantities.item_id = `accessories`.`id`
*/

/*
SELECT `item_type`, `item_id`, `stock_location_id`, `state`, max(`occurred_at`) as occurred_at
FROM `inventory_counts`
GROUP BY `item_type`, `item_id`, `stock_location_id`, `state`

$sub = InventoryCount::select('item_type', 'item_id', 'stock_location_id', 'state', )
    ->selectSub('MAX(`balances`.`created_at`)', 'refreshDate')
    ->join('balances', 'characters.id', '=', 'balances.character')
    ->whereNotNull('characters.refreshToken')
    ->groupBy('characters.id');

DB::table(DB::raw("($sub->toSql()) as t1"))
    ->mergeBindings($sub)
    ->where('refreshDate', '<', '2017-03-29')
    ->get();
*/
}