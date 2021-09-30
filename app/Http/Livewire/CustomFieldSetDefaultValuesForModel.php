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
        \Log::info("MY COMPONENT ID IS: ".$this->id);
    }

    public function foo()
    {
        \Log::info("Uh, foo?");
    }

    public function mount()
    {
        $this->model = AssetModel::find($this->model_id); // It's possible to do some clever route-model binding here, but let's keep it simple, shall we?
        $this->fieldset_id = $this->model->fieldset_id;
        $this->fields = CustomFieldset::find($this->fieldset_id)->fields;
        $this->add_default_values = ( $this->model->defaultValues->count() > 0);
        \Log::error("Model ID is: ".$this->model_id." And its fieldset is: ".$this->fieldset_id);
        \Log::error("Mount at least fired, that's got to count for something, yeah?"); //WORKS! YAY!

    }

    public function updatingFielsetId()
    {
        \Log::error("ABOUT TO UPDATE FIELDSET ID!!!");
    }

    public function updatedFieldsetId()
    {
        \Log::error("UPDATED FIELDSET ID!!!!!!");
        $this->fields = CustomFieldset::find($this->fieldset_id)->fields;
    }

    public function render()
    {
        //return '<div>Hi: {{ $this->add_default_values ? "TRUTH" : "FALSEHOOD" }} yeah?</div>';
        return view('livewire.custom-field-set-default-values-for-model');
    }
}
