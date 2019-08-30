<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

class ModalController extends Controller
{
    function location() {
        return view('modals.location');
    }

    function model() {
        return view('modals.model');
    }

    function statuslabel() {
        return view('modals.statuslabel')->with('statuslabel_types', Helper::statusTypeList());
    }

    function supplier() {
        return view('modals.supplier');
    }

    function user() {
        return view('modals.user');
    }

    function category() {
        return view('modals.category');
    }

    function manufacturer() {
        return view('modals.manufacturer');
    }

}
