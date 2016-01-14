<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
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
            'employee_id' => 'Required | Numeric | exists:users,employee_id'
        ];
    }

    public function messages()
    {
        return [
            'employee_id.exists' => 'Employee ID does not exist'
        ];
    }
}
