<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CbeInfoBusTimingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (Gate::allows('edit.cbeInfoBusTiming'))
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
            //'cbeInfoBusTiming_name' => 'required|unique:cbe_info_bus_timings,cbeInfoBusTiming_name,'.$this->cbeInfoBusTiming,
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
            // 'cbeInfoBusTiming_name.required' =>'Enter cbeInfoBusTiming_name Name',
            // 'cbeInfoBusTiming_name.unique' =>'Location cbeInfoBusTiming_name Alredy Exists',
        ];
    }

}
