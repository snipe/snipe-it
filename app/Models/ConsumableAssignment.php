<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class ConsumableAssignment extends Model
{
    use CompanyableTrait;
    use ValidatingTrait;

    protected $dates = ['deleted_at'];
    protected $table = 'consumables_users';
    protected $fillable = ['qty'];

    public $rules = array(
        'qty'         => 'integer'
    );
    
    protected $injectUniqueIdentifier = true;

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
