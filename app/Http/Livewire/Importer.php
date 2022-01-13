<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Import;

use Log;

class Importer extends Component
{
    public $files;
    public $processDetails;

    public function mount()
    {
        $this->files = Import::all();
    }

    public function test()
    {
        Log::error("Test Button Clicked!!!!");
    }

    public function toggleEvent($id)
    {
        Log::error("toggled on: ".$id);
        $this->processDetails = Import::find($id);
    }

    public function render()
    {
        return view('livewire.importer');
    }
}
