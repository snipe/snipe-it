<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;



class SlackSettingsForm extends Component
{
    public Setting $setting;

    protected $rules = [
        'setting.slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
        'setting.slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        'setting.slack_botname'                       => 'string|nullable',
        ];


    public function render()
    {
        return view('livewire.slack-settings-form');
    }

}
