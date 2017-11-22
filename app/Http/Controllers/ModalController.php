<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

class ModalController extends Controller
{
    public function location()
    {
        return view('modals.location');
    }

    public function model()
    {
        return view('modals.model')
            ->with('manufacturer', Helper::manufacturerList())
            ->with('category', Helper::categoryList('asset'));
    }

    public function statuslabel()
    {
        return view('modals.statuslabel')->with('statuslabel_types', Helper::statusTypeList());
    }

    public function supplier()
    {
        return view('modals.supplier');
    }

    public function user()
    {
        return view('modals.user');
    }
}
