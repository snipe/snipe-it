<?php

class License extends Elegant
{
    protected $guarded = 'id';
    protected $table = 'licenses';
    protected $softDelete = true;
    protected $rules = array(
            'name'   => 'required|alpha_space|min:3|max:255',
            'serial'   => 'required|alpha_space|min:5|max:255',
            'seats'   => 'required|min:1|max:10000|integer',
            'license_email'   => 'email|min:0|max:120',
            'license_name'   => 'alpha_space|min:0|max:100',
            'note'   => 'alpha_space',
            'notes'   => 'alpha_space|min:0|max:255',
        );

    /**
     * Get the assigned user
     *
     */
    public function assignedusers()
    {
        return $this->belongsToMany('User','license_seats','assigned_to','license_id');

    }

    /**
    * Get asset logs for this asset
    */
    public function assetlog()
    {
        return $this->hasMany('Actionlog','asset_id')
            ->where('asset_type', '=', 'software')
            ->orderBy('added_on', 'desc');
    }

    /**
    * Get admin user for this asset
    */
    public function adminuser()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
    * Get total licenses
    */
     public static function assetcount()
    {
        return DB::table('license_seats')
                    ->whereNull('deleted_at','and')
                    ->count();
    }

    /**
    * Get total licenses not checked out
    */
     public static function availassetcount()
    {
        return DB::table('license_seats')
                    ->where('assigned_to', '=', '0')
                    ->whereNull('deleted_at','and')
                    ->count();

    }

    /**
     * Get the number of available seats
     *
     */
    public function availcount()
    {
        return DB::table('license_seats')
                    ->where('assigned_to', '=', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
    }

    /**
     * Get the number of assigned seats
     *
     */
    public function assignedcount()
    {
        return DB::table('license_seats')
                    ->where('assigned_to', '>', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
    }

    /**
     * Get the total number of seats
     *
     */
    public function totalcount()
    {
        $avail =  $this->availcount();
        $taken =  $this->assignedcount();
        $diff =   ($avail + $taken);
        return $diff;
    }

    /**
     * Get license seat data
     *
     */
    public function licenseseats()
    {
        return $this->hasMany('LicenseSeat');
    }

    /**
     * Get depreciation class
     *
     */
    public function depreciation()
    {
        return $this->belongsTo('Depreciation','depreciation_id');
    }


     public function months_until_depreciated()
    {

            $today = date("Y-m-d");

            // @link http://www.php.net/manual/en/class.datetime.php
            $d1 = new DateTime($today);
            $d2 = new DateTime($this->depreciated_date());

            // @link http://www.php.net/manual/en/class.dateinterval.php
            $interval = $d1->diff($d2);
            return $interval;

    }


     public function depreciated_date()
    {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->depreciation->months.' months'));
            return date_format($date, 'Y-m-d');
    }



	/**
    * Handle depreciation
    */
    public function depreciate()
    {
        $depreciation_id = License::find($this->license_id)->depreciation_id;
        if ($depreciation_id) {
            $depreciation_term = Depreciation::find($depreciation_id)->months;
            if($depreciation_term>0) {

                $purchase_date = strtotime($this->purchase_date);

                $todaymonthnumber=date("Y")*12+(date("m")-1); //calculate the month number for today as YEAR*12 + (months-1) - number of months since January year 0
                $purchasemonthnumber=date("Y",$purchase_date)*12+(date("m",$purchase_date)-1); //purchase date calculated similarly
                $diff_months=$todaymonthnumber-$purchasemonthnumber;

                // fraction of value left
                $current_value = round((( $depreciation_term - $diff_months) / ($depreciation_term)) * $this->purchase_cost,2);

                if ($current_value < 0) {
                    $current_value = 0;
                }
                return $current_value;
            } else {
                return $this->purchase_cost;
            }
        } else {
            return $this->purchase_cost;
        }

    }


}
