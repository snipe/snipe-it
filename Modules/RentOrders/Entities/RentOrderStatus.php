<?php

namespace Modules\RentOrders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RentOrders\Database\factories\RentOrderStatusFactory;

class RentOrderStatus extends Model
{
    use HasFactory;

    protected $table = "rent_orders_statuses";
    protected $fillable = ["name"];
    public $timestamps = false;

    protected static function newFactory()
    {
        return RentOrderStatusFactory::new();
    }
}
