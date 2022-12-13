<?php

namespace Modules\RentOrders\Http\Livewire;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Response;
use Livewire\Component;
use Modules\RentOrders\System\RentOrderSystem;

class RentOrderForm extends Component
{
    public $assignedTo = null;
    public $selected = [];
    public $returnDate; 
    
    public $error = [
        'user' => false,
        'assets' => false,
        'returnDate' => false
    ];

    public $listeners = [
        'addAssetToList' => "addAssetToList",
        "setSelectedUser" => "setUser",
        "setReturnDate"=>"setReturnDate"
    ];

    public function render()
    {
        return view('rentorders::livewire.rent-order-form', [
            'error' => $this->error
        ]);
    }

    public function setReturnDate($date)
    {
        $this->error['returnDate'] = false;
        $this->returnDate = $date;
    }

    public function addAssetToList($id)
    {
        $this->error['assets'] = false;
        $this->selected[] = $this->assetToArray(Asset::find($id));
    }

    public function setUser($id)
    {
        $this->assignedTo = User::find($id);
        $this->error['user'] = false;
    }


    public function delete($index)
    {
        unset($this->selected[$index]);
        $this->selected = array_merge($this->selected);
    }

    private function assetToArray($asset)
    {
        return [
            "id" => $asset->id,
            "name" => $asset->model->name,
            "model_number" => $asset->model->model_number,
            "asset_tag" => $asset->asset_tag,
            "serial" => $asset->serial,
            "img" => $asset->getImageUrl()
        ];
    }

    public function createRentOrder()
    {
        if (!$this->assignedTo || count($this->selected) == 0 || !$this->returnDate) {
            $this->setErrors();
            return;
        }

        if (auth()->check()) {
            $operator = auth()->user();
            $system = app()->make(RentOrderSystem::class);
            $assets = [];
            foreach ($this->selected as $asset) {
                $assets[] = $asset['id'];
            }
            $system->send($operator->id, $this->assignedTo['id'], $assets, $this->returnDate);
            session()->flash('success_message', 'RentOrder was added successfully!');
            $this->reset();
            return redirect()->route('rentorders.index');
        }

        abort(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return void
     */
    public function setErrors(): void
    {
        $this->error = [
            'user' => ($this->assignedTo == null),
            'assets' => (count($this->selected) == 0),
            'returnDate' => ($this->assignedTo == null)
        ];
    }

}
