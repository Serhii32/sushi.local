<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('adminBusiness') ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'percent' => 'required|integer',
            'status' => 'nullable|integer|min:0|max:1',
            'startDate' => 'nullable|date',
            'startTime' => 'nullable|date_format:"H:i"',
            'endDate' => 'nullable|date',
            'endTime' => 'nullable|date_format:"H:i"',
            'dayOfWeek' => 'nullable|integer|min:1|max:7'
        ];
    }
}
