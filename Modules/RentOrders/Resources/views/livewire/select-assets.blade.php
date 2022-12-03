<div>
    <div class="form-group ">
        <label for="name" class="col-md-3 control-label">Busqueda de equipo</label>
        <div class="col-md-6 col-sm-12">
            <input class="form-control" type="text" wire:model="search">
        </div>
    </div>

    @if($search)
        @if(count($assets) >= 1)
        <div class="col-md-12" style="z-index: 1000; background-color: #FFF; position: absolute; float: left; margin-left: -10px; border: 5px solid black;
         overflow-y: auto; max-height: 400px">
            <table class="table">
                <tbody>
                    @forEach($assets as $key => $asset)
                        <tr style="cursor:pointer;">
                            <td>
                                <button wire:click.prevent="add({{$asset['id']}})" class="add_field_button btn btn-default btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td>
                                <img src="{{$asset['img']}}" alt="image" style="max-height: 50px; width: auto;" class="img-responsive">
                            </td>
                            <td>{{$asset['name']}}</td>
                            <td>{{$asset['model_number']}}</td>
                            <td>{{$asset['asset_tag']}}</td>
                            <td>{{$asset['serial']}}</td>
                        </tr>
                    @endForEach
                </tbody>
            </table>
        </div>  
        @else
        <span>No found</span>
        @endIf      
    @endIf





</div>
    

    
