<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
class NotesController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
    }
}