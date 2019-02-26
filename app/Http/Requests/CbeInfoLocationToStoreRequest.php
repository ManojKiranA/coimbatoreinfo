<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CbeInfoLocationToStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (Gate::allows('create.cbeInfoLocationTo'))
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
            'location_to_name' =>'required|unique:cbe_info_location_tos',
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
            'location_to_name.required' =>'Enter Location Name',
            'location_to_name.unique' =>'Location Name Alredy Exists',
        ];
    }

}
