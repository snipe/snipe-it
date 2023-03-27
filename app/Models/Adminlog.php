<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends SnipeModel
{
    use HasFactory;
   
    protected $fillable = ['created_at', 'item_type', 'user_id', 'item_id', 'action_type', 'note'];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function item(Model $item): Model
    {
        $this->item_id = $item->id;
        $this->item_type = get_class($item);

        return $this; 
    }
   
    public function actionType($type)
    {
        $this->action_type = $type;
        return $this;
    }
   
    public function __destruct()
    {
       ray()->clearAll(); 
        ray('adminlog destructed'); 
       if ($this->item_id && $this->item_type && $this->action_type) {
           ray('adminlog saved'); 
           $this->save();
            ray()->showApp(); 
           ray()->confetti();
         } else {
            ray()->notify('shits busted');  
            ray('adminlog not saved');  
        //    throw new \Exception("Required Methods improperly called on SnipeLog::admin", 1);
            
          
         }
        
    }
}
