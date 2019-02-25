<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone' => 'required|min:3|max:30',
            'street' => 'required|max:255',
            'building' => 'required|max:25',
            'entrance' => 'nullable|max:25',
            'house' => 'nullable|max:25',
            'apartment' => 'nullable|max:25',
            'floor' => 'nullable|max:25',
            'call' => 'nullable|integer|min:0|max:1',
            'sticks' => 'nullable|integer|min:0|max:1',
            'payment' => 'required|integer|min:0|max:1',
            'date' => 'required|integer',
            'time' => 'required|max:25',
            'change' => 'nullable|max:25',
            'persons' => 'nullable|integer',
            'comment' => 'max:1000',
        ];
    }
}
