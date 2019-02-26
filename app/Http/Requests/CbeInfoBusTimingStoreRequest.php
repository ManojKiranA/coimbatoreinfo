<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CbeInfoBusTimingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (Gate::allows('create.cbeInfoBusTiming'))
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
            //'cbeInfoBusTiming_name' =>'required',
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
            //'cbeInfoBusTiming_name.required' =>'Enter cbeInfoBusTiming Name in text Box',
        ];
    }

}
