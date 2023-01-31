<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;

class SlackSettingsForm extends Component
{
    public $slack_endpoint;
    public $slack_channel;
    public $slack_botname;
    public $successMessage;

    public Setting $setting;

    protected $rules = [
        'slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
        'slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        'slack_botname'                       => 'string|nullable',
        ];
    protected $messages = [
        'slack_endpoint.required_with' => 'Slack endpoint is required',
        'slack_endpoint.starts_with'   => 'Slack endpoint must start with https://hooks.slack.com',


    ];

    public function mount(){

        $this->setting = Setting::getSettings();
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
        $this->validate([
            'slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
            'slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
            'slack_botname'                       => 'string|nullable',
        ]);

        $this->setting->slack_endpoint = $this->slack_endpoint;
        $this->setting->slack_channel = $this->slack_channel;
        $this->setting->slack_botname = $this->slack_botname;

        $this->successMessage= trans('admin/settings/message.update.success');

    }
}
