<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CbeInfoBusViaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (Gate::allows('create.cbeInfoBusVia'))
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
            'bus_via_name' => 'required|unique:cbe_info_bus_vias',
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
            'bus_via_name.required' => 'Enter Via Route Name',
            'bus_via_name.unique' =>'Via Route Name Already Exists',
        ];
    }

}
