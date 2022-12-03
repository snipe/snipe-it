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

    public $listeners = [
        'addAssetToList' => "addAssetToList",
        "setSelectedUser" => "setUser"
    ];

    public function render()
    {
        return view('rentorders::livewire.rent-order-form');
    }

    public function addAssetToList($id)
    {
        $this->selected[] = $this->assetToArray(Asset::find($id));
    }

    public function setUser($id)
    {
        $this->assignedTo = User::find($id);
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
        if (!$this->assignedTo || count($this->selected) == 0)
            return;

        if (auth()->check()) {
            $operator = auth()->user();
            $system = app()->make(RentOrderSystem::class);
            $assets = [];
            foreach ($this->selected as $asset) {
                $assets[] = $asset['id'];
            }
            $system->send($operator->id, $this->assignedTo['id'], $assets);
            session()->flash('success_message', 'RentOrder was added successfully!');
            $this->reset();
            return redirect()->route('rentorders.index');
        }

        abort(Response::HTTP_BAD_REQUEST);
    }

}
