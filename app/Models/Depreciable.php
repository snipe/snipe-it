<?php
namespace App\Models;

use App\Models\Depreciation;
use App\Models\SnipeModel;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('\App\Models\Depreciation', 'depreciation_id');
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
        if (!$this->get_depreciation()) { // will never happen
            return $this->purchase_cost;
        }

        if ($this->get_depreciation()->months <= 0) {
            return $this->purchase_cost;
        }

        // fraction of value left
        $months_remaining = $this->time_until_depreciated()->m + 12*$this->time_until_depreciated()->y; //UGlY
        $current_value = round(($months_remaining/ $this->get_depreciation()->months) * $this->purchase_cost, 2);

        if ($current_value < 0) {
            $current_value = 0;
        }
        return $current_value;
    }

    public function time_until_depreciated()
    {
        // @link http://www.php.net/manual/en/class.datetime.php
        $d1 = new \DateTime();
        $d2 = $this->depreciated_date();

        // @link http://www.php.net/manual/en/class.dateinterval.php
        $interval = $d1->diff($d2);
        if (!$interval->invert) {
            return $interval;
        } else {
            return new \DateInterval("PT0S"); //null interval (zero seconds from now)
        }
    }

    public function depreciated_date()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->get_depreciation()->months . ' months'));
        return $date; //date_format($date, 'Y-m-d'); //don't bake-in format, for internationalization
    }
}
