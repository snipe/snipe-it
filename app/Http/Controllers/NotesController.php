<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('update', Asset::class);

        $validated = $request->validate([
            'id' => 'required',
            'note' => 'required|string|max:50000',
            'type' => [
                'required',
                Rule::in(['asset']),
            ],
        ]);

        $item = Asset::findOrFail($validated['id']);

        $this->authorize('update', $item);

        $item->setLogNote($validated['note']);
        $item->setLogAction(ActionType::NoteAdded);
        $item->save();

        return redirect()
            ->route('hardware.show', $validated['id'])
            ->withFragment('history')
            ->with('success', trans('general.note_added'));
    }
}
