<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;
use App\Http\Requests\Request;



class SlackSettingsForm extends Component
{
    public $slack_endpoint;
    public $slack_channel;
    public $slack_botname;

    public Setting $setting;

    protected $rules = [
        'slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
        'slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        'slack_botname'                       => 'string|nullable',
        ];

    public function mount(){

        $this->setting= Setting::getSettings();
        $this->slack_endpoint = $this->setting->slack_endpoint;
        $this->slack_channel = $this->setting->slack_channel;
        $this->slack_botname = $this->setting->slack_botname;

    }

    public function render()
    {
        return view('livewire.slack-settings-form');
    }

    public function submit()
    {

        $this->validate();

        $this->setting->slack_endpoint = $this->slack_endpoint;
        $this->setting->slack_channel = $this->slack_channel;
        $this->setting->slack_botname = $this->slack_botname;

    }
}
