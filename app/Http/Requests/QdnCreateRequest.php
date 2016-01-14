<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QdnCreateRequest extends Request
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
            'package_type'         => 'required',
            'device_name'          => 'required',
            'lot_id_number'        => 'required',
            'lot_quantity'         => 'required | numeric',
            'job_order_number'     => 'required',
            'machine'              => 'required',
            'station'              => 'required',
            'receiver_name'        => 'required',
            'major'                => 'required',
            'failure_mode'         => 'required',
            'discrepancy_category' => 'required',
            'problem_description'  => 'required'
        ];
    }
}
