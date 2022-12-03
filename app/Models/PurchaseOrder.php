<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemOrder;

class PurchaseOrder extends SnipeModel
{
    const STATES = [
        'INITIAL' => 0,
        'SEND' => 1,
        'RECEIVED' => 2,
        'CLOSED' => 3,
        'ABORTED' => 4
    ];

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Category validation rules
     */
    public $rules = [
        'name'          => 'required|min:1|max:255',
        'state'         => 'required'
    ];

    // public function existItemAsset(int $id): bool
    // {
    //     return ItemOrder::where(['item_id' => $id, 'item' => Asset::class])->count() > 0;
    // }   

    // public function assets()
    // {
    //     return $this->morphMany(Asset::class, 'item');
    // }

    // public function consumables()
    // {
    //     return $this->morphMany(Consumable::class, 'consumables');
    // }
    

    // public function components()
    // {
    //     return $this->morphMany(Component::class, 'item');
    // }

    

    // public function accesories()
    // {
    //     return $this->morphMany(Accessory::class, 'item');
    // }

    public function itemOrders()
    {
        return $this->hasMany(ItemOrder::class);
    }

}