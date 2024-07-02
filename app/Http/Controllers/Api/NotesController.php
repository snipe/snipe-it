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
        $this->authorize('update', $item);

        $validated = $request->validate([
            'note' => 'required|string|max:500']);

        event(new NoteAdded($item, Auth::user(), $validated['note']));

        return response()->json(Helper::formatStandardApiResponse('success'));
    }

}