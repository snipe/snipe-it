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

    public function mount()
    {
        if(is_null($this->model_id)){
            return;
        }
            
        $this->model = AssetModel::find($this->model_id); // It's possible to do some clever route-model binding here, but let's keep it simple, shall we?
        $this->fieldset_id = $this->model->fieldset_id;

        $this->fields = null;

        if ($fieldset = CustomFieldset::find($this->fieldset_id)) {
            $this->fields = CustomFieldset::find($this->fieldset_id)->fields;
        } 

        $this->add_default_values = ($this->model->defaultValues->count() > 0);
    }

    public function updatedFieldsetId()
    {
        if (CustomFieldset::find($this->fieldset_id)) {
            $this->fields = CustomFieldset::find($this->fieldset_id)->fields;
        }
        
    }

    public function render()
    {
        return view('livewire.custom-field-set-default-values-for-model');
    }
}
