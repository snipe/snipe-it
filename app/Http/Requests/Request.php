<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected $rules = [];

    public function rules()
    {
        return $this->rules;
    }

    // public function response(array $errors)
    // {
    //     $this->session->flash('errorMessages', $errors);
    //     return $this->redirector->back()->withErrors($errors)->withInput();
    // }
}
