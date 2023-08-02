<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends SnipeModel
{
    use HasFactory;
   
    protected $fillable = [
        'created_at', 
        'item_type', 
        'user_id', 
        'item_id', 
        'action_type', 
        'note'
    ];
   
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
   
    public function actor(User $user)
    {
       $this->user_id = $user->id; 
       return $this;
    }
}
