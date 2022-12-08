<?php

namespace Modules\RentOrders\Http\Livewire;

use App\Models\Asset;
use Livewire\Component;

class SelectAssets extends Component
{
    public $assignedTo;
    public $search;


    public function add($id)
    {
        $this->emit('addAssetToList', $id);
        $this->search = '';
    }



    public function render()
    {
        return view('rentorders::livewire.select-assets', [
            "assets" => $this->getAssets()
        ]);
    }

    /**
     * @return mixed
     */
    private function getAssets()
    {
        $assets =  Asset::join('models', "assets.model_id", '=', 'models.id')
            ->select('assets.*')
            ->whereRaw('assets.status_id = 2 and assets.assigned_to is null 
                        and (
                            assets.serial like "%'.$this->search.'%" 
                            or assets.name like "%'.$this->search.'%" 
                            or assets.asset_tag like "%'.$this->search.'%" 
                            or models.name like "%'.$this->search.'%" 
                            or models.model_number like "%'.$this->search.'%" 
                        )')
            ->get();


        $data = [];
        foreach($assets as $asset) {
            $data[] = $this->assetToArray($asset);
        }

        return $data;
    }

    private function assetToArray($asset){
        return [
            "id"=>$asset->id,
            "name" =>$asset->model->name,
            "model_number"=> $asset->model->model_number,
            "asset_tag" => $asset->asset_tag,
            "serial"=>$asset->serial,
            "img" => $asset->getImageUrl()
        ];
    }

    public function clearSearch(){
        $this->search = '';
    }
}
