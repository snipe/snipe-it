<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Get info on the current user.
     *
     * @author [Juan Font] [<juanfontalonso@gmail.com>]
     * @since [v4.4.2]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo(Request $request)
    {
        return response()->json($request->user());
    }

}