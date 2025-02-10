<?php

namespace App\Http\Controllers\Api;

use App\Events\NoteAdded;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotesController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:500',
            'type' => [
                'required',
                Rule::in(['asset']),
            ],
        ]);

        // This can be made dynamic by using $request->input('type') to determine which model type to add the note to.
        // For now, we are only placing this on Assets
        $item = Asset::findOrFail($request->input("id"));
        $this->authorize('update', $item);

        event(new NoteAdded($item, Auth::user(), $validated['note']));

        return response()->json(Helper::formatStandardApiResponse('success'));
    }

    public function update(Request $request)
    {

    }
    public function destroy(Request $request)
    {

    }
}
