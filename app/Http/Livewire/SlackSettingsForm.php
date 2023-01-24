<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;



class SlackSettingsForm extends Component
{
    public Setting $setting;



    public function render()
    {
        return view('livewire.slack-settings-form');
    }

}
