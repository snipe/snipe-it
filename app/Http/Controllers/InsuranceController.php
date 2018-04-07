<?php

namespace App\Http\Controllers;

use App\Models\Insurance;


class InsuranceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index()
    {

        $this->authorize('view', Insurance::class);
        return view('insurance.index', compact('insurance'));
    }

    public function show($id)
    {
        $this->authorize('view', Insurance::class);
        if ($insurance = Insurance::find($id)) {
            return view('insurance.view')->with('insurance', $insurance);
        }

        return redirect()->route('insurance.index')->with('error', trans('admin/insurance/message.does_not_exist', compact('id')));

    }

    public function create() {
        return view('insurance.edit');
    }
}