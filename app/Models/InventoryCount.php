<?php
namespace App\Models;

use App\Models\Traits\InventoryActions;
use App\Enums\States;
use App\Enums\AssetTypes;
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

    public function invcountable()
    {
        return $this->morphTo();
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

    public function recentQuantitiesByState($group = null, $wheres = null)
    {
      $sub = $this->lastCounts();

      if (!$group) {
        $group = ['item_type', 'item_id', 'stock_location_id'];
      }
      if (!$wheres || !array_key_exists('state', $wheres)) {
        if (!$wheres) 
          $wheres = [];

        $wheres['state'] = States::$main_states;
      }
      if (!is_array($wheres['state'])) {
        $wheres['state'] = [
          $wheres['state']
        ];
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
        // Have to CAST because otherwise decimal returns as a string
        $query->addSelect(DB::raw("CAST(SUM(CASE WHEN `state` = '{$value}' THEN `qty` ELSE 0 END) AS INTEGER) AS {$value}"));
      }
      $query->addSelect(DB::raw("CAST(SUM(`qty`) AS INTEGER) AS total"));

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


    public function recentQuantitiesByItem($group = null, $wheres = null, $states = null)
    {
      $sub = $this->lastCounts();

      if (!$group) {
        $group = ['item_type', 'item_id', 'stock_location_id'];
      }
      if (!$wheres || !array_key_exists('item_type', $wheres)) {
        if (!$wheres) 
          $wheres = [];

        $wheres['item_type'] = AssetTypes::$allAssetTypes;
      }
      if (!is_array($wheres['item_type'])) {
        $wheres['item_type'] = [ $wheres['item_type'] ];
      }


      // start query
      $query = InventoryCount::query();

      // Add selects based on grouping
      if (in_array('item_id', $group))
        $query->addSelect('item_id');
      if (in_array('stock_location_id', $group))
        $query->addSelect('stock_location_id');
      if (in_array('state', $group))
        $query->addSelect('item_type');


      // add quantities sums based on states
      foreach ($wheres['item_type'] as $key => $value) {
        $matchString = str_replace('\\', "\\\\", $value);
        $name = AssetTypes::$typePluralNames[$value];
        // Have to CAST because otherwise decimal returns as a string
        $query->addSelect(DB::raw("CAST(SUM(CASE WHEN `item_type` = '{$matchString}' THEN `qty` ELSE 0 END) AS INTEGER) AS '{$name}'"));
      }
      //dd($query->toSql());
      $query->addSelect(DB::raw("CAST(SUM(`qty`) AS INTEGER) AS total"));

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
}