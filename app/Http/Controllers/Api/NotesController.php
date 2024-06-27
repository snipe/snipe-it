<?php

namespace App\Http\Controllers\Api;

use App\Events\NoteAdded;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        $item = Asset::findOrFail($request->input("id"));

        event(new NoteAdded($item, Auth::user(), $request->input("note")));

        if ($item->save()) {
            return response()->json(Helper::formatStandardApiResponse('success'));
        }
    }

}