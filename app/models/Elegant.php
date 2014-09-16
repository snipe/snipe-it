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
    
    public function is_required($field)
    {
        foreach ($this->rules as $attribute => $rules)
	{
            if($attribute == $field)
            {
                return str_contains($rules, 'required');  
            }
	}
        
        return false;
    }
    
    public function max_length($field)
    {
        foreach ($this->rules as $attribute => $rules)
	{
            if($attribute == $field)
            {
                if(str_contains($rules, 'max'))
                {
                    $rule = (is_string($rules)) ? explode('|', $rules) : $rules;
                    foreach($rule as $r)
                    {
                        if(str_contains($r, 'max'))
                        {
                            $max = explode(':', $r, 2);
                            return $max[1];
                        }
                    }
                }
                
                return str_contains($rules, 'required');  
            }
	}
        
        return 0;
    }
}
