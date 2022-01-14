<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Import;

use Log;

class Importer extends Component
{
    public $files;
    public $processDetails;
    public $forcerefresh;

    protected $rules = [
        'files.*.file_path' => 'required|string',
        'files.*.created_at' => 'required|string',
        'files.*.filesize' => 'required|integer'
    ];

    public function mount()
    {
        //$this->files = Import::all(); // this *SHOULD* be how it works, but...it doesn't?
        $this->forcerefresh = 0;
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
        $this->files = Import::all(); //HACK - slows down renders.
        return view('livewire.importer');
    }
}
