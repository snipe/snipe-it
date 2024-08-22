<?php

namespace App\Livewire;

use App\Models\CustomField;
use Livewire\Attributes\Computed;
use Livewire\Component;

use App\Models\CustomFieldset;
use App\Models\AssetModel;

class CustomFieldSetDefaultValuesForModel extends Component
{
    public $add_default_values;

    public $fieldset_id;
    public $model_id;

    public array $selectedValues = [];

    public function mount($model_id = null)
    {
        $this->model_id = $model_id;
        $this->fieldset_id = $this->model?->fieldset_id;
        $this->add_default_values = ($this->model?->defaultValues->count() > 0);

        $this->fields->each(function ($field) {
            $this->setSelectedValueForField($field);
        });

        dump(old('default_values'));
        dump($this->selectedValues);
    }

    #[Computed]
    public function model()
    {
        return AssetModel::find($this->model_id);
    }

    #[Computed]
    public function fields()
    {
        $customFieldset = CustomFieldset::find($this->fieldset_id);

        if ($customFieldset) {
            return $customFieldset?->fields;
        }

        return collect();
    }

    public function render()
    {
        return view('livewire.custom-field-set-default-values-for-model');
    }

    private function setSelectedValueForField(CustomField $field): void
    {
        $defaultValue = $field->defaultValue($this->model_id);

        if (old('default_values.' . $field->id)) {
            // @todo: need to handle old input being null on purpose...
            $defaultValue = old('default_values.' . $field->id);
        }

        // on first load the default value for checkboxes will be
        // a comma-separated string but if we're loading the page
        // with old input then it was already parsed into an array.
        if ($field->element === 'checkbox' && is_string($defaultValue)) {
            $this->selectedValues[$field->db_column] = explode(', ', $defaultValue);
        } else {
            $this->selectedValues[$field->db_column] = $defaultValue;
        }
    }
}
