<?php


interface StateInterface {
    public function checkIn();
    public function checkOut($user_id);
    public function delete();    
    public function getCheckoutButton();
    public function getStatusButton();   
    public function getSelect();
   
}

abstract class AssetState extends Eloquent implements StateInterface {
    
    protected $asset; 
    
    public function __construct($asset_in)
    {
        $this->asset = $asset_in;
    }  
    
    public function delete()
    {
        return false;
    }
    
    public function checkOut($user_id) 
    {    
       return false;
    }

    public function checkIn() 
    {    
        return false;
    }   
    
    public function prepare()
    {
       return false;
    }
    
    public function getSelect()
    {
        return Form::select('status_id', Statuslabel::where('id' , '!=' , 3)->orderBy('id', 'asc')->lists('name', 'id') , Input::old('status_id', $this->asset->status_id), array('class'=>'select2', 'style'=>'width:350px'));
       
    }
    
    public function getCheckoutButton()
    {
        return '';
    }
}

class UnavailableState extends AssetState{    
    public function delete()
    {
        $this->asset->status_id = null; 
        $this->asset->save();
        
        return $this->asset->delete();
    }   
    
    public function getStatusButton()
    {
        return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }
}

class PendingState extends AssetState{
    
    public function delete()
    {
        $this->asset->status_id = null; 
        $this->asset->save();
        
        return $this->asset->delete();
    }       
    
     public function getStatusButton()
    {
        return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }
    
    public function getCheckoutButton()
    {    
        return '<a href="' . route('prepare/hardware', $this->asset->id) .'" class="btn btn-success">'.Lang::get('actions.ready').'</a> ';
    }
    
    public function prepare()
    {

        $this->asset->status_id = 2;
        return $this->asset->save();
  
    }
}

class AvailableState extends AssetState{    
    public function delete()
    {
        $this->asset->status_id = null; 
        $this->asset->save();
        
        return $this->asset->delete();
    }
    
    public function checkout($user_id) 
    {
        $this->asset->assigned_to = $user_id;
        $this->asset->status_id = 3;
        
        return ($this->asset->save());       
    }  
    
    public function getCheckoutButton()
    {
        return '<a href="' . route('checkout/hardware', $this->asset->id) .'" class="btn btn-info">'.Lang::get('actions.checkout').'</a> ';
    }
    
    public function getStatusButton()
    {
        return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }  
}

class AssingedState extends AssetState{
    
    public function getSelect()
    {
        return '<input type="hidden" id="status_id" name="status_id" value="'.$this->asset->status_id .'" />'
                . '<input type="hidden" id="assigned_to" name="assigned_to" value="'.$this->asset->assigned_to .'" />'
                . '<input type="hidden" id="user_id" name="user_id" value="'.$this->asset->user_id .'" />'
                . '<a href="' . route('checkin/hardware', $this->asset->id) .'" class="btn btn-primary">'.Lang::get('actions.checkin').'</a> ';
    }
    
    public function checkIn() {
        
        $this->asset->assigned_to = 0;
        $this->asset->status_id = 2;
        
        return $this->asset->save();
    }
    
    public function getCheckoutButton()
    {
         
        return '<a href="' . route('checkin/hardware', $this->asset->id) .'" class="btn btn-primary">'.Lang::get('actions.checkin').'</a> ';
    }
    
    public function getStatusButton()
    {
        return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" disabled=true
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }

}

class OtherState extends AssetState{
    
    public function delete()
    {
        $this->asset->status_id = null; 
        $this->asset->save();
        
        return $this->asset->delete();
    }
 
    public function getStatusButton()
    {
         return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }

}

class DeletedState extends AssetState{
       
    public function delete()
    {
       //completely delete the item
        $this->asset->forceDelete();
        return true;
    }
    
     public function getStatusButton()
    {
         
        return '<a href="'. route('restore/hardware', $this->asset->id) . '" class="btn btn-warning"><span class="icon-share-alt icon-white"></span></a>' .            
        ' <a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="'. route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;">
                            <i class="icon-remove icon-white"></i>
                            </a>';
    }
    
}
