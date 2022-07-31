<?php

namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class ReserveTask extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name', 'description', 'task_date', 'task_end_date'
    ];
}