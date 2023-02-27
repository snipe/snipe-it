<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Setting;

class SlackSettingsForm extends Component
{
    public $slack_endpoint;
    public $slack_channel;
    public $slack_botname;
    public $isDisabled ='disabled' ;
    public $integration_app= 'WORKING';
    public $webhook_link;
    public $webhook_selected;
    public $webhook_options= ['Slack'=>'fab fa-slack', 'Discord'=>'fab fa-discord', 'Rocket.Chat'=>'fab fa-rocketchat'];
    public $webhook;
    public $icon;

    public Setting $setting;

    protected $rules = [
        'slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
        'slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        'slack_botname'                       => 'string|nullable',
    ];

    public function mount(){

        $this->setting = Setting::getSettings();
        $this->icon ='';
        $this->webhook = $this->webhook_selected;
        $this->slack_endpoint = $this->setting->slack_endpoint;
        $this->slack_channel = $this->setting->slack_channel;
        $this->slack_botname = $this->setting->slack_botname;

    }
    public function updated($field){

        $this->webhook = $this->webhook_selected;
        $this->validateOnly($field ,$this->rules);
    }

    public function render()
    {
        if(empty($this->slack_channel || $this->slack_endpoint)){
            $this->isDisabled= 'disabled';
        }
        if(empty($this->slack_endpoint && $this->slack_channel)){
            $this->isDisabled= '';
        }
        return view('livewire.slack-settings-form');
    }

    public function testSlack(){

        $slack = new Client([
            'base_url' => e($this->slack_endpoint),
            'defaults' => [
                'exceptions' => false,
            ],
        ]);

        $payload = json_encode(
            [
                'channel'    => e($this->slack_channel),
                'text'       => trans('general.slack_test_msg'),
                'username'    => e($this->slack_botname),
                'icon_emoji' => ':heart:',
            ]);

        try {
            $slack->post($this->slack_endpoint, ['body' => $payload]);
            $this->isDisabled='';
            return session()->flash('success' , 'Your Slack Integration works!');

        } catch (\Exception $e) {
            $this->isDisabled= 'disabled';
            return session()->flash('error' , trans('admin/settings/message.slack.error', ['error_message' => $e->getMessage()]));
        }

        //}
        return session()->flash('message' , trans('admin/settings/message.slack.error_misc'));



    }
    public function submit()
    {
        $this->validate($this->rules);

        $this->setting->slack_endpoint = $this->slack_endpoint;
        $this->setting->slack_channel = $this->slack_channel;
        $this->setting->slack_botname = $this->slack_botname;

        $this->setting->save();

        session()->flash('save',trans('admin/settings/message.update.success'));


    }
}
