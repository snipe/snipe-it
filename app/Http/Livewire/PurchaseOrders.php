<?php

namespace App\Http\Livewire;

use App\PurchaseOrder;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PurchaseOrders extends LivewireDatatable
{
    public $model = PurchaseOrder::class;

    public function columns()
    {
        //
    }
}