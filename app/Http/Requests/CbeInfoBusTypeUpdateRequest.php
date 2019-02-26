<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CbeInfoBusTypeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (Gate::allows('edit.cbeInfoBusType'))
        // {
        //     return true;
        // }else {
        //     abort(403, 'Unauthorized.');
        // }
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
            'bus_type_name' => 'required|unique:cbe_info_bus_types,bus_type_name,'.$this->cbeInfoBusType,
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {

        return [
            'bus_type_name.required' =>'Enter Bus Type Name',
            'bus_type_name.unique' => 'Bus Type Alredy Exists',
        ];
    }

}
