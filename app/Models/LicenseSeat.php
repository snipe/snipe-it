<?php
namespace App\Models;

use App\Models\Traits\Acceptable;
use App\Notifications\CheckinLicenseNotification;
use App\Notifications\CheckoutLicenseNotification;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;

class LicenseSeat extends SnipeModel implements ICompanyableChild
{
    use CompanyableChildTrait;
    use SoftDeletes;
    use Loggable;

    protected $presenter = 'App\Presenters\LicenseSeatPresenter';
    use Presentable;

    protected $dates = ['deleted_at'];
    protected $guarded = 'id';
    protected $table = 'license_seats';

    use Acceptable;

    public function getCompanyableParents()
    {
        return ['asset', 'license'];
    }

    /**
     * Determine whether the user should be required to accept the license
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return boolean
     */
    public function requireAcceptance()
    {
        return $this->license->category->require_acceptance;
    }

    public function getEula() {
        return $this->license->getEula();
    }
    
    /**
     * Establishes the seat -> license relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function license()
    {
        return $this->belongsTo('\App\Models\License', 'license_id');
    }

    /**
     * Get the target this license seat is checked out to
     *
     * @author [D. Stumm] [@dennis95stumm]
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function assignedTo()
    {
        return $this->morphTo('assigned', 'assigned_type', 'assigned_to');
    }

    /**
     * Gets the lowercased name of the type of target the license seat is assigned to
     *
     * @author [D. Stumm] [@dennis95stumm]
     * @return string
     */
    public function assignedType()
    {
        return strtolower(class_basename($this->assigned_type));
    }
}
