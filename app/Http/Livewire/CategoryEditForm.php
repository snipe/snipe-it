<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CategoryEditForm extends Component
{
    public $defaultEulaText;

    public $eulaText;

    public $requireAcceptance;

    public $sendCheckInEmail;

    public $useDefaultEula;

    public function mount()
    {
        if ($this->eulaText || $this->useDefaultEula) {
            $this->sendCheckInEmail = true;
        }
    }

    public function render()
    {
        return view('livewire.category-edit-form');
    }

    public function updated($property, $value)
    {
        if (in_array($property, ['eulaText', 'useDefaultEula']) && ($this->eulaText || $this->useDefaultEula)) {
            $this->sendCheckInEmail = (bool)$value;
        }
    }

    public function getShouldDisplayEmailMessageProperty(): bool
    {
        return $this->eulaText || $this->useDefaultEula;
    }

    public function getEmailMessageProperty(): string
    {
        if ($this->useDefaultEula) {
            return trans('admin/categories/general.email_will_be_sent_due_to_global_eula');
        }

        return trans('admin/categories/general.email_will_be_sent_due_to_category_eula');
    }
}
