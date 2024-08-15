<?php

namespace App\Livewire;

use App\Models\CustomField;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

use App\Models\CustomFieldset;
use App\Models\AssetModel;

class CustomFieldSetDefaultValuesForModel extends Component
{
    public $add_default_values;

    public $fieldset_id;
    public $model_id;

    public Collection $cachedValues;

    public function mount($model_id = null)
    {
        $this->model_id = $model_id;
        $this->fieldset_id = $this->model?->fieldset_id;
        $this->add_default_values = ($this->model?->defaultValues->count() > 0);

        $this->cachedValues = collect();

        $this->fields->each(function ($field) {
            $this->cachedValues->put($field->db_column, $field->defaultValue($this->model_id));
        });
    }

    public function getValueForField(CustomField $field)
    {
        return $this->cachedValues->get($field->db_column);
    }

    public function updateFieldValue($dbColumn, $updatedValue): void
    {
        $this->cachedValues->put($dbColumn, $updatedValue);
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
}
