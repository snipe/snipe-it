<?php

namespace App\Http\Livewire;
use App\Models\Setting;
use Livewire\Component;
use App\Http\Requests\Request;


class ModalComponents extends Component
{
    public $settings;
    public $multiCompany;
    public $multi_company_alert;
    public $modal_removal_alert;

    protected $listeners = ['openModal'];

    public function mount($multiCompany) {
        $this->settings= Setting::getSettings();
        $this->modal_removal_alert = trans('admin/settings/general.multi_company_alert_removal',['url' => route('settings.general.index')]);
        $this->multiCompany = $multiCompany;



}
    public function cancelEdit(){
            $this->save();
            return redirect()->to('hardware');
    }
    public function continueEdit(){
            $this->save();
            return true;
    }
    public function multiCompanyAlert() {
        if($this->multiCompany) {
            return session()->flash('warning', "NOTE: One or more of the assets you are editing belong to different companies.");
        }
    }

    public function openModal(){
        if($this->multiCompany) {
            $this->emit('show');
        }
    }
    public function save(){
        $this->settings->multi_company_alert =$this->multi_company_alert;
    }
    public function render(){

            return view('livewire.modal-components');

    }
}
