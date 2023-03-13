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
    public $webhook_name;
    public $webhook_link;
    public $webhook_placeholder;
    public $webhook_icon;
    public $webhook_selected;

    public Setting $setting;

    protected $rules = [
        'webhook_endpoint'                      => 'url|required_with:webhook_channel|starts_with:https://hooks.slack.com/services|nullable',
        'webhook_channel'                       => 'required_with:webhook_endpoint|starts_with:#|nullable',
        'webhook_botname'                       => 'string|nullable',
    ];
    static $webhook_text= [
        "slack" => array(
            "name" => "Slack",
            "icon" => 'fab fa-slack',
            "placeholder" => "https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX",
            "link" => 'https://api.slack.com/messaging/webhooks',
        ),
//        "Discord" => array(
//            "name" => "Discord",
//            "icon" => 'fab fa-discord',
//            "placeholder" => "https://discord.com/api/webhooks/XXXXXXXXXXXXXXXXXXXXX",
//            "link" => 'https://support.discord.com/hc/en-us/articles/360045093012-Server-Integrations-Page',
//        ),
        "general"=> array(
            "name" => "General",
            "icon" => "fab fa-hashtag",
            "placeholder" => "",
            "link" => "",
        ),
    ];

    public function mount(){

        $this->setting = Setting::getSettings();
        $this->webhook_selected = $this->setting->webhook_selected;
        $this->webhook_placeholder = self::$webhook_text[$this->setting->webhook_selected]["placeholder"];
        $this->webhook_name = self::$webhook_text[$this->setting->webhook_selected]["name"];
        $this->webhook_icon = self::$webhook_text[$this->setting->webhook_selected]["icon"];
        $this->webhook_endpoint = $this->setting->webhook_endpoint;
        $this->webhook_channel = $this->setting->webhook_channel;
        $this->webhook_botname = $this->setting->webhook_botname;
        $this->webhook_options = $this->setting->webhook_selected;


    }
    public function updated($field){
        if($this->webhook_selected != 'general') {
            $this->validateOnly($field, $this->rules);
        }
    }
    public function updatedWebhookSelected(){
        $this->webhook_name = self::$webhook_text[$this->webhook_selected]['name'];
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

        $webhook = new Client([
            'base_url' => e($this->webhook_endpoint),
            'defaults' => [
                'exceptions' => false,
            ],
        ]);

        $payload = json_encode(
            [
                'channel'    => e($this->webhook_channel),
                'text'       => trans('general.webhook_test_msg'),
                'username'    => e($this->webhook_botname),
                'icon_emoji' => ':heart:',
            ]);

        try {
            $webhook->post($this->webhook_endpoint, ['body' => $payload]);
            $this->isDisabled='';
            return session()->flash('success' , 'Your '.$this->webhook_name.' Integration works!');

        } catch (\Exception $e) {
            $this->isDisabled= 'disabled';
            return session()->flash('error' , trans('admin/settings/message.webhook.error', ['error_message' => $e->getMessage(), 'app' => $this->webhook_name]));
        }

        //}
        return session()->flash('message' , trans('admin/settings/message.webhook.error_misc'));



    }
    public function submit()
    {
        if($this->webhook_selected != 'general') {
            $this->validate($this->rules);
        }

        $this->setting->webhook_selected = $this->webhook_selected;
        $this->setting->webhook_endpoint = $this->webhook_endpoint;
        $this->setting->webhook_channel = $this->webhook_channel;
        $this->setting->webhook_botname = $this->webhook_botname;


        $this->setting->save();

        session()->flash('save',trans('admin/settings/message.update.success'));


    }
}
