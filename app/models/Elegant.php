<?php

class Elegant extends Eloquent
{
    protected $rules = array();
    protected $errors;

    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules);

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
    
    public function validationRules($id = '0')
    {
        return str_replace("{id}", $id, $this->rules);
    }

    /**
     * @param $depreciation_id
     * @param $purchase_cost
     * @param $purchase_date1
     * @return float|int
     */
    protected function getCurrentValue($depreciation_id, $purchase_cost, $purchase_date1)
    {
        if (!$depreciation_id) {
            return $purchase_cost;
        }

        $depreciation_term = Depreciation::find($depreciation_id)->months;
        if ($depreciation_term <= 0) {
            return $purchase_cost;
        }

        $purchase_date = strtotime($purchase_date1);

        $todaymonthnumber = date("Y") * 12 + (date("m") - 1); //calculate the month number for today as YEAR*12 + (months-1) - number of months since January year 0
        $purchasemonthnumber = date("Y", $purchase_date) * 12 + (date("m", $purchase_date) - 1); //purchase date calculated similarly
        $diff_months = $todaymonthnumber - $purchasemonthnumber;

        // fraction of value left
        $current_value = round((($depreciation_term - $diff_months) / ($depreciation_term)) * $purchase_cost, 2);

        if ($current_value < 0) {
            $current_value = 0;
        }
        return $current_value;
    }
}
