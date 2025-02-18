<?php

namespace App\Http\Controllers;

use App\Events\NoteAdded;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        // @todo: validation

        $item = Asset::findOrFail($request->input('id'));

        // @todo: authorization

        event(new NoteAdded($item, Auth::user(), $request->input('note')));

        return redirect()
            // @todo: make dynamic
            ->route('hardware.show', $request->input('id'))
            ->withFragment('history')
            // @todo: translate
            ->with('success', 'Success!');
    }
}
