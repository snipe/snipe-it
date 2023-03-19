<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomField;

use Log;

class ImporterFile extends Component
{

    protected $listeners = [
        'refreshFile' => '$refresh'
    ];



    public function updatedActiveFile()
    {
        \Log::error("We have updated the active file! WHOOOO!!");

        // unset all of the input doodads,
        // maybe unset or reset some properties up in here.

    }




    public function mount()
    {
    }

    public function postSave()
    {
        //does this, like, do anything, or get used by anything?
        if (!$this->activeFile->import_type) {
            Log::error("didn't find an import type :(");
            $this->statusType ='error';
            $this->statusText = "An import type is required... "; // TODO - translate me!
            return false;
        }
        $this->statusType = 'pending';
        $this->statusText = trans('admin/hardware/form.processing_spinner');

    }

    public function render()
    {
        return view('livewire.importer-file');
    }
}
