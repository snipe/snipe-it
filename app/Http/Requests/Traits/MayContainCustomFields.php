<?php

namespace App\Http\Requests\Traits;

use App\Models\AssetModel;

trait MayContainCustomFields
{
    // this gets called automatically on a form request
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $request_fields = $this->collect()->keys()->filter(function ($attributes) {
                return str_starts_with($attributes, '_snipeit_');
            });
            if (count($request_fields) > 0) {
                if ($this->method() == 'POST') {
                    $request_fields->diff(AssetModel::find($this->model_id)->fieldset->fields->pluck('db_column'))
                        ->each(function ($request_field_name) use ($request_fields, $validator) {
                            // i could probably add some more conditions here to determine whether or not the column exists but just not on this asset model
                            // and then return a more helpful error message
                            $validator->errors()->add($request_field_name, 'This field does not seem to exist (at least on this asset), please double check your custom field names.');
                        });
                } elseif ($this->method() == 'PUT' || $this->method() == 'PATCH') {
                    // need to know about other pr before I can go down this route
                }
            }

        });
    }
}

