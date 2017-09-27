<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }
}
