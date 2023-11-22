<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class ModalComponents extends Component
{
    public $action;
    public $multiCompany;

    protected $listeners = ['openModal'];

    public function mount($multiCompany) {

        $this->multiCompany = $multiCompany;


}
    public function cancelEdit(){

            return redirect()->to('hardware');
    }
    public function continueEdit(){
            return true;
    }

    public function openModal(){
        if($this->multiCompany) {
            $this->emit('show');
        }
    }
    public function render(){

            return view('livewire.modal-components');

    }
}
