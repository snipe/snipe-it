<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomFieldset;

class CustomFieldsForFieldset extends Component
{
    public $fieldset_id;
    public $fields;

    public function render()
    {
        if($this->fieldset_id) {
            $this->fields = CustomFieldset::find($this->fieldset_id)->fields()->get();
        }
        return view('livewire.custom-fields-for-fieldset');
    }
}
