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

    /**
     * Query builder scope to order on department
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderDepartments($query, $order)
    {
        return $query->leftJoin('users as license_seat_users',  'license_seats.assigned_to', '=', 'license_seat_users.id')
            ->leftJoin('departments as license_user_dept',  'license_user_dept.id', '=', 'license_seat_users.department_id')
            ->orderBy('license_user_dept.name', $order);
    }




}
