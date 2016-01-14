<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewPasswordRequest extends Request
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
        'password' => 'required | min:6 | same:password_2',
        'password_2' => 'required | min:6'
        ];
    }

    public function messages()
    {
    return [
            'password.same' => 'Password did not match, please try again'
        ];
    }
}
