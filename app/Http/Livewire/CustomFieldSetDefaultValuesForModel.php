<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomFieldset;
use App\Models\AssetModel;

class CustomFieldSetDefaultValuesForModel extends Component
{
    public $add_default_values;

    public $fieldset_id;
    public $fields;
    public $model_id;


    public function __construct()
    {
        \Log::info("INSTANTIATING A THING!!!"); // WORKS!
    }

    public function foo()
    {
        \Log::info("Uh, foo?");
    }

    public function mount()
    {
        $this->fieldset_id = AssetModel::find($this->model_id)->fieldset_id;
        \Log::error("Mount at least fired, that's got to count for something, yeah?"); //WORKS! YAY!

    }

    public function render()
    {
        // return 'fart<div>Hi: {{ $this->add_default_values }} yeah?</div>';
        if($this->fieldset_id) {
            $this->fields = CustomFieldset::find($this->fieldset_id)->fields()->get();
        }
        return view('livewire.custom-field-set-default-values-for-model');
    }
}
