<?php

class Asset extends Elegant
{
    protected $table = 'assets';
    protected $softDelete = true;
    protected $errors;
    protected $rules = array(
        'name'              => 'alpha_space|min:6|max:255',        
        'model_id'          => 'required',        
        'warranty_months'   => 'integer|min:0|max:240',
        'note'              => 'alpha_space',
        'notes'             => 'alpha_space',
        'pysical'           => 'integer',
        'supplier_id'       => 'integer',
        'asset_tag'         => 'required|alpha_space|min:3|max:255|unique:assets,asset_tag,{id}',
        'serial'            => 'required|alpha_dash|min:3|max:255|unique:assets,serial,{id}',
        'status'            => 'integer'
        );
    
    private $inPreparationsState;
    private $readyToDeployState;
    private $assignedState;
    private $outForDiagnosticsState;
    private $outForRepairState;
    private $brokenState;
    private $lostState;
    private $decommissionedState;
    private $deletedState;
    private $unknownState;
    
    public  $state;

    public function __construct($attributes = array())  {
        parent::__construct($attributes); // Eloquent   
        
        $this->supplier_id = DB::table('defaults')->where('name', 'supplier_asset')->pluck('value');
        $this->status_id = DB::table('defaults')->where('name', 'asset_status')->pluck('value');        
        
        $this->inPreparationsState = new inPreparationsState($this);
        $this->readyToDeployState = new readyToDeployState($this);
        $this->assignedState = new assignedState($this);
        $this->outForDiagnosticsState = new outForDiagnosticsState($this);
        $this->outForRepairState = new outForRepairState($this);
        $this->brokenState = new brokenState($this);
        $this->lostState = new lostState($this);
        $this->decommissionedState = new decommissionedState($this);
        $this->deletedState = new deletedState($this);
        $this->unknownState = new unknownState($this); 
        $this->state = $this->inPreparationsState;
    }
    
    public function newFromBuilder($attributes = array())
    {
        $instance = parent::newFromBuilder($attributes);
        $instance->state = $instance->determineState($instance->status_id);
        return $instance;
    }
    
    public static function boot()
    {
        parent::boot();

        static::updated(function($asset)
        {
           $asset->state = $asset->determineState($asset->status_id);
        });       
    }
    
    public function scopeUndelpoyable($query)
    {
        return $query->where('status_id', '>', 3)->where('physical', '=', 1);
    } 
    
    public function scopeReadyToDeploy($query)
    {
        return $query->where('status_id', '=', 2)->where('assigned_to','=','0')->where('physical', '=', 1);
    }  
    
    public function scopeDeployed($query)
    {
        return $query->where('status_id', '=', 3)->where('assigned_to','>','0')->where('physical', '=', 1);
    }  
    
    public function scopePending($query)
    {
        return $query->where('status_id', '=', 1)->where('assigned_to','=','0')->where('physical', '=', 1);
    }  
    
    public function checkin() {
        $this->state->checkIn();
    }
    
    public function checkout() {
        $this->state->checkOut();
    } 
    
    public function setState($state_in) {
        $this->state = $this->determineState($state_in);
        $this->state->set();
    }   
    
    private function determineState($status_id_in)
    {
        switch ($status_id_in) {
            case 1:
                return $this->inPreparationsState;
                break;
            case 2:
                return $this->readyToDeployState;
                break;
            case 3:
                return $this->assignedState;
                break;
            case 4:
                return $this->outForDiagnosticsState;
                break;
            case 5:
                return $this->outForRepairState;
                break;
            case 6:
                return $this->brokenState;
                break;
            case 7:
                return $this->lostState;
                break;
            case 8:
                return $this->decommissionedState;
                break;
            case 9:
                return $this->deletedState;
                break;
            default:
                return  $this->unknownState;
                
        }
    }
    /**
    * Handle depreciation
    */
    public function depreciate()
    {
        $depreciation_id = Model::find($this->model_id)->depreciation_id;
        if ($depreciation_id) {
            $depreciation_term = Depreciation::find($depreciation_id)->months;
            if($depreciation_term>0) {

                $purchase_date = strtotime($this->purchase_date);

                $todaymonthnumber=date("Y")*12+(date("m")-1); //calculate the month number for today as YEAR*12 + (months-1) - number of months since January year 0
                $purchasemonthnumber=date("Y",$purchase_date)*12+(date("m",$purchase_date)-1); //purchase date calculated similarly
                $diff_months=$todaymonthnumber-$purchasemonthnumber;

                // fraction of value left
                $current_value = round((( $depreciation_term - $diff_months) / ($depreciation_term)) * $this->purchase_cost,2);

                if ($current_value < 0) {
                    $current_value = 0;
                }
                return $current_value;
            } else {
                return $this->purchase_cost;
            }
        } else {
            return $this->purchase_cost;
        }

    }

    public function assigneduser()
    {        
        return $this->belongsTo('User', 'assigned_to');
    }

    /**
    * Get the asset's location based on the assigned user
    **/
    public function assetloc()
    {
        return $this->assigneduser->userloc();
    }

    /**
    * Get action logs for this asset
    */
    public function assetlog()
    {
        return $this->hasMany('Actionlog','asset_id')->where('asset_type','=','hardware')->orderBy('added_on', 'desc')->withTrashed();
    }

    /**
    * Get action logs for this asset
    */
    public function adminuser()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
    * Get total assets
    */
     public static function assetcount()
    {
        return DB::table('assets')
                    ->where('physical', '=', '1')
                    ->whereNull('deleted_at','and')
                    ->count();
    }

    /**
    * Get total assets not checked out
    */
     public static function availassetcount()
    {
        return Asset::orderBy('asset_tag', 'ASC')->where('status_id', '=', 0)->where('assigned_to','=','0')->where('physical', '=', 1)->count();

    }

    /**
    * Get total assets
    */
     public function assetstatus()
    {
        return $this->belongsTo('Statuslabel','status_id');
    }


     public function warrantee_expires()
    {

            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->warranty_months.' months'));
            return date_format($date, 'Y-m-d');

    }

     public function months_until_depreciated()
    {

            $today = date("Y-m-d");

            // @link http://www.php.net/manual/en/class.datetime.php
            $d1 = new DateTime($today);
            $d2 = new DateTime($this->depreciated_date());

            // @link http://www.php.net/manual/en/class.dateinterval.php
            $interval = $d1->diff($d2);
            return $interval;

    }


     public function depreciated_date()
    {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->depreciation->months.' months'));
            return date_format($date, 'Y-m-d');
    }


    public function depreciation()
    {
        return $this->model->belongsTo('Depreciation','depreciation_id');
    }

    public function model()
    {
        return $this->belongsTo('Model','model_id');
    }

	/**
	* Get the license seat information
	**/
     public function licenses()
    {
       	return $this->belongsToMany('License', 'license_seats', 'asset_id', 'license_id');

    }

     public function licenseseats()
    {
    		return $this->hasMany('LicenseSeat', 'asset_id');
    }


    public function supplier()
    {
        return $this->belongsTo('Supplier','supplier_id');
    }

    public function months_until_eol()
    {
            $today = date("Y-m-d");
            $d1 = new DateTime($today);
            $d2 = new DateTime($this->eol_date());

            if ($this->eol_date() > $today) {
                $interval = $d2->diff($d1);
            } else {
                $interval = NULL;
            }

            return $interval;
    }

    public function eol_date()
    {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->eol.' months'));
            return date_format($date, 'Y-m-d');
    }
}

interface AssetState {
    public function checkIn();
    public function checkOut($user_id);
    public function delete();    
    public function getCheckoutButton();
    public function getStatusButton();
    public function getStateText();
    public function getStateID();
    public function set();
}

class inPreparationsState implements AssetState{
    private $asset;    
    private $state_id = 1;
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function checkOut($user_id) {
        
       return false;
    }

    public function checkIn() {
        
        return false;
    }   
   
    
    public function getCheckoutButton()
    {
        return "";
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
    
    public function getStateText()
    {
        return Lang::get('/admin/statuslabels/table.state.preparing');
    }
}

class readyToDeployState implements AssetState{
    private $asset; 
    private $state_id = 2;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
        public function set()
    {
        $this->asset->status_id = $this->state_id;
        return($this->asset->save());      
        
        
    }
    
    
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
   
    
    public function checkout($user_id) {
        
        $this->asset->assigned_to = $user_id;
        $this->asset->status_id = 3;
        
        if($this->asset->save())
        {            
            $this->asset->setState(3);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkIn() {
        return false;
    }
    

    
    public function getCheckoutButton()
    {
        
        return '<a href="' . route('checkout/hardware', $this->asset->id) .'" class="btn btn-primary">'.Lang::get('general.checkout').'</a> ';
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
    
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.readyToDeploy');
    }
}

class assignedState implements AssetState{
    private $asset; 
    private $state_id = 3;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        //canot delete checked out asset
        return false;
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        return false;
        //check out asset
    }

    public function checkIn() {
        $this->asset->assigned_to = 0;
        $this->asset->status_id = 2;
        
        if($this->asset->save())
        {            
            $this->asset->setState(2);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getCheckoutButton()
    {
         
        return '<a href="' . route('checkin/hardware', $this->asset->id) .'" class="btn btn-primary">'.Lang::get('general.checkin').'</a> ';
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
    
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.assigned');
    }
}

class outForDiagnosticsState implements AssetState{
    private $asset;    
    private $state_id = 4;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        
        return false;
    }

    public function checkIn() {
        
        return false;
    }
    

    
    public function getCheckoutButton()
    {
        return "";
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
    
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.outForDiagnostics');
    }
}

class outForRepairState implements AssetState{
    private $asset;        
    private $state_id = 5;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        
        return false;
    }

    public function checkIn() {
        return false;
    }

    
    public function getCheckoutButton()
    {
        return "";
    }
    
        public function getStatusButton()
    {
         return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . ' <a data-html="false"  
                            title="Delete Asset ' . $this->asset->asset_tag . '?"
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }
    
        public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.outForRepair');
    }
}

class brokenState implements AssetState{
    private $asset;    
    private $state_id = 6;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        
        return false;
    }

    public function checkIn() {
        return false;
    }

    
    public function getCheckoutButton()
    {
        return "";
    }
    
        public function getStatusButton()
    {
         return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> '                 
                . '<a data-html="false"                             
                            class="btn delete-asset btn-danger" 
                            data-toggle="modal" 
                            href="' . route('delete/hardware', $this->asset->id)  . '" 
                            data-content="' . Lang::get('admin/hardware/message.delete.confirm') . '" 
                            data-title="' . Lang::get('general.delete') . htmlspecialchars($this->asset->asset_tag) . '?" 
                            onClick="return false;" ><i class="icon-trash icon-white"></i></a>';
    }
    
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.broken');
       
    }
}

class lostState implements AssetState{
    private $asset;    
    private $state_id = 7;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        return false;
    }

    public function checkIn() {
        return false;
    }
    

    
    public function getCheckoutButton()
    {
        return "";
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
        
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.lost');
    }
    
}

class decommissionedState implements AssetState{
    private $asset;    
    private $state_id = 8;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        
        //check out asset
        return false;
    }

    public function checkIn() {
        return false;        
    }
    

    
    public function getCheckoutButton()
    {
        return "";
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
    
     public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.decommissioned');
    }
}

class deletedState implements AssetState{
    private $asset;   
    private $state_id = 9;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    
    public function delete()
    {
       //completely delete the item
        $this->asset->forceDelete();
        return true;
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        
        $this->asset->delete();
                  
    }
    
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function checkOut($user_id) {
        
        //check out asset
        return false;
    }

    public function checkIn() {
        return false;
    }

    
    public function getCheckoutButton()
    {
        return "";
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
    
    public function getStateText()
    {
        return Lang::get('/admin/statuslabels/table.state.delete');
    }
}

class unknownState implements AssetState{
    private $asset;    
    private $state_id;
    
    public function getStateID()
    {
        return $this->state_id;
    }
    public function __construct(Asset $asset_in){
        $this->asset = $asset_in;
    }
    
    public function delete()
    {
        $this->asset->status_id = 9; 
        $this->asset->save();
        return $this->asset->delete();
    }
    
    public function set()
    {
        $this->asset->status_id = $this->state_id;
        $this->asset->save();          
    }
    
    public function checkOut($user_id) {
        
        //check out asset
        return false;
    }

    public function checkIn() {
        return false;
    }
    

    public function getCheckoutButton()
    {
        return "";
    }
    
        public function getStatusButton()
    {
        return '<a href="' . route('update/hardware', $this->asset->id) . '" class="btn btn-warning"><i class="icon-pencil icon-white" alt="Edit"></i></a> ';
    }
    
    public function getStateText()
    {
        return  Lang::get('/admin/statuslabels/table.state.unknown');
    }
}


