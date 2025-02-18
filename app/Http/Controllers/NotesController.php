<?php

namespace App\Http\Controllers;

use App\Events\NoteAdded;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // @todo: improve?
            'id' => 'required',
            'note' => 'required|string|max:500',
            'type' => [
                'required',
                Rule::in(['asset']),
            ],
        ]);

        $item = Asset::findOrFail($validated['id']);

        // @todo: authorization

        event(new NoteAdded($item, Auth::user(), $validated['note']));

        return redirect()
            ->route('hardware.show', $validated['id'])
            ->withFragment('history')
            // @todo: translate
            ->with('success', 'Note Added!');
    }
}
