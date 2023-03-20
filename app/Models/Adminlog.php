<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminLog extends SnipeModel
{
    use HasFactory;
   
    protected $fillable = ['created_at', 'item_type', 'user_id', 'item_id', 'action_type', 'note'];
}
