<?php
namespace App\Models;

use App\Models\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\CheckoutLicenseNotification;
use App\Notifications\CheckinLicenseNotification;

class LicenseSeat extends Model implements ICompanyableChild
{
    use CompanyableChildTrait;
    use SoftDeletes;
    use Loggable;

    protected $dates = ['deleted_at'];
    protected $guarded = 'id';
    protected $table = 'license_seats';

    /**
     * Set static properties to determine which checkout/checkin handlers we should use
     */
    public static $checkoutClass = CheckoutLicenseNotification::class;
    public static $checkinClass = CheckinLicenseNotification::class;

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

    public function location()
    {
        if (($this->user) && ($this->user->location)) {
            return $this->user->location;

        } elseif (($this->asset) && ($this->asset->location)) {
            return $this->asset->location;
        }

        return false;

    }
}
