<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrder extends SnipeModel
{
    use HasFactory;

    // 0 Abierta, 1 Cerrado, 2 Cancelado

    const STATE_EMPTY = 0;
    const STATE_LOAD_OK = 1;
    const STATE_ABORTED = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items_orders';

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


    public function item()
    {
        return $this->morphTo();
    }
   
}
