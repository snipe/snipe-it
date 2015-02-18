<?php

class Depreciable extends Elegant
{
    /**
    * Depreciation Relation, and associated helper methods
    */

    //REQUIRES a purchase_date field
    //     and a purchase_cost field

    public function depreciation()
    {
        return $this->belongsTo('Depreciation','depreciation_id');
    }

    /**
     * @param $purchase_cost
     * @param $purchase_date1
     * @return float|int
     */

    protected function getCurrentValue()
    {
        if (!$this->depreciation) { // will never happen
            return $this->purchase_cost;
        }

        if ($this->depreciation->months <= 0) {
            return $this->purchase_cost;
        }

        // fraction of value left
        $current_value = round(($this->time_until_depreciated() / ($this->depreciation->months)) * $this->purchase_cost, 2);

        if ($current_value < 0) {
            $current_value = 0;
        }
        return $current_value;
    }

    public function time_until_depreciated()
    {
        // @link http://www.php.net/manual/en/class.datetime.php
        $d1 = new DateTime();
        $d2 = $this->depreciated_date();

        // @link http://www.php.net/manual/en/class.dateinterval.php
        $interval = $d1->diff($d2);
        if(!$interval->invert) {
            return $interval;
        } else {
            return new DateInterval("PT0S"); //null interval (zero seconds from now)
        }
    }

    public function depreciated_date()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->depreciation->months . ' months'));
        return $date; //date_format($date, 'Y-m-d'); //don't bake-in format, for internationalization
    }    
}