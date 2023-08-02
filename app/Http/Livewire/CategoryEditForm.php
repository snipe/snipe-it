<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CategoryEditForm extends Component
{
//    public bool $displayEmailMessage = false;

    public bool $checkinEmail;

    public $defaultEulaText;

    public $eulaText;

    public bool $requireAcceptance;

    public bool $useDefaultEula;

    public function mount()
    {

    }

    public function updated($a, $b)
    {
//        dd($a, $b);
    }

    public function render()
    {
        return view('livewire.category-edit-form');
    }

    public function getDisplayEmailMessageProperty(): bool
    {
        return false;
    }

    public function getEmailMessageProperty(): string
    {
        // @todo:
        return '';
    }
}
