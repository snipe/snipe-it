<?php
namespace App\Models;

use App\Models\Traits\InventoryActions;
use App\Enums\States;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use Illuminate\Validation\Rule;


class InventoryAdjustment extends Model
{
    use InventoryActions;
    protected $dates = ['occurred_at'];
    protected $table = 'inventory_adjustments';

    public $rules = array(
        'item_type'         => 'required|string',
        'item_id'           => 'required|integer',
        'from_state'        => 'required',
        'to_state'          => 'required',
        'stock_location_id' => 'required|integer',
        'qty'               => 'required|min:1',
        'occurred_at'        => 'nullable',
        'source_id'         => 'nullable|integer',
        'reference_id'      => 'nullable|integer',
        'price'             => 'nullable|numeric',
        'notes'             => 'nullable|string',
    );
    use ValidatingTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_type', 'item_id', 'from_state','to_state','stock_location_id','qty','occurred_at','user_id','source_id','reference_id', 'price', 'note'];

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

    /* Save override function instead of saveAndCount ?
    public function save(array $options = array())
    {
      parent::save($options);
    }
    */

    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @param  \App\Models\InventoryAdjustment

     * @since [v4.8]
     * @return \App\Models\InventoryAdjustment
     */

    public function saveAndCount($force = false)
    {
      return $this->addAdjustment($force);
    }
    /* Save override function instead of saveAndCount ?
    public function save(array $options = array())
    {
      parent::save($options);
    }
    */

    private function addAdjustment($force = false)
    {
      if ($force) {
        $this->forceSave(); // skips validation rule
      } else {
        if (!$this->save())
          return false;
      }
      // create a new inventory count for each state
      $this->makeInvCount($this->item_type, $this->item_id, $this->stock_location_id, $this->from_state);
      $this->makeInvCount($this->item_type, $this->item_id, $this->stock_location_id, $this->to_state);
      return true;
    }

}