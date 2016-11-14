<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAllAssets(Request $request)
    {
        return response()->json(Asset::all());
    }
}
