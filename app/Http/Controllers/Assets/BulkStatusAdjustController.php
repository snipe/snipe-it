<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkStatusAdjustController extends Controller
{
    public function show() {
        // Temporarily redirect to home
        return redirect()->route('home');
    }
}
