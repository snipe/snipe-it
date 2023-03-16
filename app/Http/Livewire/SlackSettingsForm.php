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
    public array $webhook_text;

    public Setting $setting;

    protected $rules = [
        'webhook_endpoint'                      => 'url|required_with:webhook_channel|starts_with:https://hooks.slack.com/services|nullable',
        'webhook_channel'                       => 'required_with:webhook_endpoint|starts_with:#|nullable',
        'webhook_botname'                       => 'string|nullable',
    ];


    public function mount(){
        $this->webhook_text= [
            "slack" => array(
                "name" => trans('admin/settings/general.slack') ,
            "icon" => 'fab fa-slack',
            "placeholder" => "https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX",
            "link" => 'https://api.slack.com/messaging/webhooks',
        ),
            "general"=> array(
                "name" => trans('admin/settings/general.general_webhook'),
                "icon" => "fab fa-hashtag",
                "placeholder" => "",
                "link" => "",
            ),
        ];

        $this->setting = Setting::getSettings();
        $this->webhook_selected = $this->setting->webhook_selected;
        $this->webhook_placeholder = $this->webhook_text[$this->setting->webhook_selected]["placeholder"];
        $this->webhook_name = $this->webhook_text[$this->setting->webhook_selected]["name"];
        $this->webhook_icon = $this->webhook_text[$this->setting->webhook_selected]["icon"];
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
        $this->webhook_name = $this->webhook_text[$this->webhook_selected]['name'];
        $this->webhook_icon = $this->webhook_text[$this->webhook_selected]["icon"]; ;
        $this->webhook_placeholder = $this->webhook_text[$this->webhook_selected]["placeholder"];
        $this->webhook_link = $this->webhook_text[$this->webhook_selected]["link"];

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
                'text'       => trans('general.webhook_test_msg', ['app' => $this->webhook_name]),
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
