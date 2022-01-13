<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomField;

class ImporterFile extends Component
{
    public $activeFile; //should this get auto-filled?
    public $customFields;

    public function mount()
    {
        $customFields = CustomField::all();
    }

    public function render()
    {
        return view('livewire.importer-file');
    }
}
