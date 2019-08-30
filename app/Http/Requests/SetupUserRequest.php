<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SetupUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'site_name' => 'required|string|min:1',
          'first_name' => 'required|string|min:1',
          'last_name' => 'required|string|min:1',
          'username' => 'required|string|min:2|unique:users,username,NULL,deleted_at',
          'email' => 'email|unique:users,email',
          'password' => 'required|min:6|confirmed',
          'email_domain' => 'required|min:4',
        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
