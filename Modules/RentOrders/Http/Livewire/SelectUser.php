<?php

namespace Modules\RentOrders\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SelectUser extends Component
{
    public $assignedTo;

    public function render()
    {
        return view('rentorders::livewire.select-user', [
            'users' => User::all()->toArray()
        ]);
    }

    public function setSelectedUser($id){
        $this->assignedTo = $id;
    }
}
