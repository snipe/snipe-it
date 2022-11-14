<?php

namespace App\Models;

class Depreciable extends SnipeModel
{
    /**
     * Depreciation Relation, and associated helper methods
     */

    //REQUIRES a purchase_date field
    //     and a purchase_cost field

    //REQUIRES a get_depreciation method,
    //which will return the deprecation.
    //this is needed because assets get
    //their depreciation from a model,
    //whereas licenses have deprecations
    //directly associated with them.

    //assets will override the following
    //two methods in order to inherit from
    //their model instead of directly (like
    //here)

    public function depreciation()
    {
        return $this->belongsTo(\App\Models\Depreciation::class, 'depreciation_id');
    }

    public function get_depreciation()
    {
        return $this->depreciation;
    }

    /**
     * @return float|int
     */
    public function getDepreciatedValue()
    {
        if (! $this->get_depreciation()) { // will never happen
            return $this->purchase_cost;
        }

        if ($this->get_depreciation()->months <= 0) {
            return $this->purchase_cost;
        }
        $depreciation = 0;
        $setting = Setting::getSettings();
        switch ($setting->depreciation_method) {
            case 'half_1':
            $depreciation = $this->getHalfYearDepreciatedValue(true);
            break;

            case 'half_2':
            $depreciation = $this->getHalfYearDepreciatedValue(false);
            break;

            default:
            $depreciation = $this->getLinearDepreciatedValue();
        }

        return $depreciation;
    }

    /**
     * @return float|int
     */
    public function getLinearDepreciatedValue() // TODO - for testing it might be nice to have an optional $relative_to param here, defaulted to 'now'
    {
        if ($this->purchase_date) {
            $months_passed = ($this->purchase_date->diff(now())->m)+($this->purchase_date->diff(now())->y*12);
        } else {
            return null;
        }

        if ($months_passed >= $this->get_depreciation()->months){
            //if there is a floor use it
            if(!$this->get_depreciation()->depreciation_min == null) {

                $current_value = $this->get_depreciation()->depreciation_min;

            }else{
                $current_value = 0;
            }
        }
        else {
            // The equation here is (Purchase_Cost-Floor_min)*(Months_passed/Months_til_depreciated)
            $current_value = round(($this->purchase_cost-($this->purchase_cost - ($this->get_depreciation()->depreciation_min)) * ($months_passed / $this->get_depreciation()->months)), 2);

        }

        return $current_value;
    }

    public function getMonthlyDepreciation(){

        return ($this->purchase_cost-$this->get_depreciation()->depreciation_min)/$this->get_depreciation()->months;

    }

    /**
     * @param onlyHalfFirstYear Boolean always applied only second half of the first year
     * @return float|int
     */
    public function getHalfYearDepreciatedValue($onlyHalfFirstYear = false)
    {
        // @link http://www.php.net/manual/en/class.dateinterval.php
        $current_date = $this->getDateTime();
        $purchase_date = date_create($this->purchase_date);
        $currentYear = $this->get_fiscal_year($current_date);
        $purchaseYear = $this->get_fiscal_year($purchase_date);
        $yearsPast = $currentYear - $purchaseYear;
        $deprecationYears = ceil($this->get_depreciation()->months / 12);
        if ($onlyHalfFirstYear) {
            $yearsPast -= 0.5;
        } elseif (! $this->is_first_half_of_year($purchase_date)) {
            $yearsPast -= 0.5;
        }
        if (! $this->is_first_half_of_year($current_date)) {
            $yearsPast += 0.5;
        }

        if ($yearsPast >= $deprecationYears) {
            $yearsPast = $deprecationYears;
        } elseif ($yearsPast < 0) {
            $yearsPast = 0;
        }

        return round($yearsPast / $deprecationYears * $this->purchase_cost, 2);
    }

    /**
     * @param \DateTime $date
     * @return int
     */
    protected function get_fiscal_year($date)
    {
        $year = intval($date->format('Y'));
        // also, maybe it'll have to set fiscal year date
        if ($date->format('nj') === '1231') {
            return $year;
        } else {
            return $year - 1;
        }
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    protected function is_first_half_of_year($date)
    {
        $date0m0d = intval($date->format('md'));

        return ($date0m0d < 601) || ($date0m0d >= 1231);
    }

    public function time_until_depreciated()
    {
        // @link http://www.php.net/manual/en/class.datetime.php
        $d1 = new \DateTime();
        $d2 = $this->depreciated_date();

        // @link http://www.php.net/manual/en/class.dateinterval.php
        $interval = $d1->diff($d2);
        if (! $interval->invert) {
            return $interval;
        } else {
            return new \DateInterval('PT0S'); //null interval (zero seconds from now)
        }
    }

    public function depreciated_date()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->get_depreciation()->months.' months'));

        return $date; //date_format($date, 'Y-m-d'); //don't bake-in format, for internationalization
    }

    // it's necessary for unit tests
    protected function getDateTime($time = null)
    {
        return new \DateTime($time);
    }
}
