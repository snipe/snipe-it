<?php

namespace App\Http\Livewire;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalComponents extends Component
{
    public $modal_change;
    public $multiCompany;

    public function mount($multiCompany) {
        $this->multiCompany = $multiCompany;
        $this->dispatchBrowserEvent('show-modal');
}
    public function checkSession(){
    }
    public function multiCompanyAcknowledge(Request $request, $action){
        dd('hi',$action);
        if ($action =='cancel') {
            $this->modal_change = $request->session()->pull('company_uniq', 'null');
            return redirect()->back();
        }
        if ($action =='accept') {
            $this->modal_change = $request->session()->pull('company_uniq', 'null');
        }
    }
    public function showModal(){
        return view('livewire.modal-components');
    }
    public function render()
    {
            return view('livewire.modal-components');
    }
}
