<?php

namespace App\Http\Controllers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NotesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('update', Asset::class);

        $validated = $request->validate([
            'id' => 'required',
            'note' => 'required|string|max:50000',
            'type' => [
                'required',
                Rule::in(['asset', 'maintenance']),
            ],
        ]);

        if ($validated['type'] === 'maintenance') {
            $item = Maintenance::findOrFail($validated['id']);
            $this->authorize('update', $item->asset);
            $redirect = redirect()->route('maintenances.show', $validated['id']);
        } else {
            $item = Asset::findOrFail($validated['id']);
            $this->authorize('update', $item);
            $redirect = redirect()->route('hardware.show', $validated['id']);
        }

        $logaction = new Actionlog;
        $logaction->item_id = $item->id;
        $logaction->item_type = get_class($item);
        $logaction->note = $validated['note'];
        $logaction->created_by = Auth::id();
        $logaction->logaction('note added');

        return $redirect->withFragment('notes')->with('success', trans('general.note_added'));
    }
}
