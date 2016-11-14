<?php
namespace App\Models;

<<<<<<< HEAD
=======
use App\Models\Loggable;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicenseSeat extends Model implements ICompanyableChild
{
    use CompanyableChildTrait;
    use SoftDeletes;
<<<<<<< HEAD
=======
    use Loggable;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

    protected $dates = ['deleted_at'];
    protected $guarded = 'id';
    protected $table = 'license_seats';

    public function getCompanyableParents()
    {
        return ['asset', 'license'];
    }

    public function license()
    {
        return $this->belongsTo('\App\Models\License', 'license_id');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'assigned_to')->withTrashed();
    }

    public function asset()
    {
        return $this->belongsTo('\App\Models\Asset', 'asset_id')->withTrashed();
    }
}
