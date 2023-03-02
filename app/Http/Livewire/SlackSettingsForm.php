<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Setting;

class SlackSettingsForm extends Component
{
    public $webhook_endpoint;
    public $webhook_channel;
    public $webhook_botname;
    public $isDisabled ='disabled' ;
    public $webhook_link;
    public $webhook_placeholder;
    public $webhook_icon;
    public $webhook_selected;

    public Setting $setting;

    protected $rules = [
        'webhook_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
        'webhook_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        'webhook_botname'                       => 'string|nullable',
    ];
    static $webhook_text= [
        "Slack" => array(
            "icon" => 'fab fa-slack',
            "placeholder" => "https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX",
            "link" => 'https://api.slack.com/messaging/webhooks'
        ),
        "Discord" => array(
            "icon" => 'fab fa-discord',
            "placeholder" => "https://discord.com/api/webhooks/XXXXXXXXXXXXXXXXXXXXX",
            "link" => 'https://support.discord.com/hc/en-us/articles/360045093012-Server-Integrations-Page'
        ),
        "RocketChat"=> array(
            "icon" => 'fab fa-rocketchat',
            "placeholder" => "https://discord.com/api/webhooks/XXXXXXXXXXXXXXXXXXXXX",
            "link" => '',
        ),
    ];

    public function mount(){

        $this->setting = Setting::getSettings();
        $this->webhook_endpoint = $this->setting->webhook_endpoint;
        $this->webhook_channel = $this->setting->webhook_channel;
        $this->webhook_botname = $this->setting->webhook_botname;
        $this->webhook_options = $this->setting->webhook_selected;


    }
    public function updated($field){
//        $this->webhook_selected = $this->webhook_options;
        $this->validateOnly($field ,$this->rules);
    }
    public function updatedWebhookSelected(){

        $this->webhook_icon = self::$webhook_text[$this->webhook_selected]["icon"]; ;
        $this->webhook_placeholder = self::$webhook_text[$this->webhook_selected]["placeholder"];
        $this->webhook_link = self::$webhook_text[$this->webhook_selected]["link"];

    }

    public function render()
    {
        if(empty($this->webhook_channel || $this->webhook_endpoint)){
            $this->isDisabled= 'disabled';
        }
        if(empty($this->webhook_endpoint && $this->webhook_channel)){
            $this->isDisabled= '';
        }
        return view('livewire.slack-settings-form');
    }

    public function testWebhook(){

        $slack = new Client([
            'base_url' => e($this->webhook_endpoint),
            'defaults' => [
                'exceptions' => false,
            ],
        ]);

        $payload = json_encode(
            [
                'channel'    => e($this->webhook_channel),
                'text'       => trans('general.slack_test_msg'),
                'username'    => e($this->webhook_botname),
                'icon_emoji' => ':heart:',
            ]);

        try {
            $slack->post($this->webhook_endpoint, ['body' => $payload]);
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

        $this->setting->webhook_selected = $this->webhwebhook_selected;
        $this->setting->webhook_endpoint = $this->webhook_endpoint;
        $this->setting->webhook_channel = $this->webhook_channel;
        $this->setting->webhook_botname = $this->webhook_botname;

        $this->setting->save();

        session()->flash('save',trans('admin/settings/message.update.success'));


    }
}
