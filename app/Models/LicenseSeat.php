<?php
namespace App\Models;

use App\Models\Loggable;
use App\Models\Relationships\LicenseSeatRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\CheckoutLicenseNotification;
use App\Notifications\CheckinLicenseNotification;

class LicenseSeat extends Model implements ICompanyableChild
{
    use CompanyableChildTrait,SoftDeletes,Loggable,LicenseSeatRelationships;

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
