<?php

namespace App\Http\Controllers\Api;

use App\Events\NoteAdded;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        //dynamically call type of first class object
        switch(request('type'))
        {
            case 'Asset':
                return Asset::findOrFail($request->input("id"));
            case 'Accessory':
                return Accessory::findOrFail($request->input("id"));
            case 'Location':
                return Location::findOrFail($request->input("id"));
            case 'User':
                return User::findOrFail($request->input("id"));
        }

        //$item = request('type');

        event(new NoteAdded($item, Auth::user(), $request->input("note")));

        if ($item->save()) {
            return response()->json(Helper::formatStandardApiResponse('success'));
        }
    }

    private function input(string $string)
    {
    }
}