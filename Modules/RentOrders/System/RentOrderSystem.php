<?php

namespace Modules\RentOrders\System;

use App\Models\Asset;
use App\Models\User;
use Modules\RentOrders\Entities\RentOrder;


class RentOrderSystem
{
    public function send($operatorUserId, $assignedToId, $assetsIds, $returnDate){

        $operator = User::find($operatorUserId);
        $assinedTo = User::find($assignedToId);
        $assets = Asset::whereIn('id', $assetsIds)->get();

        foreach ($assets as $asset){
            $asset->checkOut($assinedTo, $operator);
            $asset->save();
        }

        return RentOrder::createWith($operator, $assinedTo, $assets, $returnDate);
    }

    public function deleteOrderWithId($id, $user){
        $order = RentOrder::find($id);
        foreach ($order->assets as $asset){
           /** @var Asset $asset */
            $asset->declinedCheckout($user, '');
        }
        RentOrder::destroy($id);
    }
}