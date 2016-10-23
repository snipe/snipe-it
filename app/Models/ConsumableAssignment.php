<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableAssignment extends Model
{
    use CompanyableTrait;

    protected $dates = ['deleted_at'];
    protected $table = 'consumables_users';

    public function consumable()
    {
        return $this->belongsTo('\App\Models\Consumable');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'assigned_to');
    }

    public function admin()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
