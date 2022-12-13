<?php

namespace Modules\RentOrders\Entities;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RentOrders\Database\factories\RentOrderFactory;

class RentOrder extends Model
{
    use HasFactory;

    protected $table = "rent_orders";

    protected $fillable = ['created_by', 'assigned_to', 'status', 'return_date'];

    protected $casts = [
        'renturn_date' => 'datetime:Y-m-d'
    ];

    public static function createWith($operator, $assinedTo, $assets, $returnDate)
    {       

        $rentOrder = RentOrder::create([
            'created_by' => $operator->id,
            'assigned_to' => $assinedTo->id,
            "status" => RentOrderStatus::find(2)->id,
            'return_date' => $returnDate
        ]);

        $rentOrder->assets()->saveMany($assets);

        return $rentOrder;
    }

    protected static function newFactory()
    {
        return RentOrderFactory::new();
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function create_by()
    {
        return $this->belongsTo(User::class);
    }

    public function assigned_to()
    {
        return $this->belongsTo(User::class, "assigned_to_id");
    }

    public function status()
    {
        return $this->belongsTo(RentOrderStatus::class);
    }
}
