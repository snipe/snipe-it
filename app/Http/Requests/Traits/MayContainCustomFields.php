<?php

namespace App\Http\Requests\Traits;

trait MayContainCustomFields
{
    //public function after()
    //{
    //    dd($this);
    //    $request_data = $this;
    //}

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $custom_fields = $this->collect()->keys()->filter(function ($attributes) {
                return str_starts_with($attributes, '_snipeit_');
            });
            if (count($custom_fields) > 0) {
                if ($this->method() == 'POST') {
                    dd($this->model_id);
                } elseif ($this->method() == 'PUT' || $this->method() == 'PATCH') {
                    dd($this->asset());
                }
            }

        });
    }
}

