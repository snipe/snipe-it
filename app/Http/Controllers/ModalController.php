<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

class ModalController extends Controller
{
    function show($type, $itemId = null) {
        $view = view("modals.${type}");

        if($type == "statuslabel") {
            $view->with('statuslabel_types', Helper::statusTypeList());
        }
        if(in_array($type, ['kit-model', 'kit-license', 'kit-consumable', 'kit-accessory'])) {
            $view->with('kitId', $itemId);
        }
        return $view;
    }
}
