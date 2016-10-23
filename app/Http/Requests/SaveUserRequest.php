<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveUserRequest extends Request
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
            'first_name'              => 'required|string|min:1',
            'email'                   => 'email',
            'password'                => 'required|min:6',
            'password_confirm'        => 'sometimes|required_with:password',
            'username'                => 'required|string|min:2|unique:users,username,NULL,deleted_at',
        ];
    }
}
