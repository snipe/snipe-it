<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedReportsController extends Controller
{
    public function store(Request $request)
    {
        dd('saved reports', $request->all());
    }
}
