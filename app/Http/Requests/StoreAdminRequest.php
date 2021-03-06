<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class StoreAdminRequest extends FormRequest
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
        // $response = dd($this->all());
        // return response()->json($response);
        return [
            'name' => 'required|min:3|max:191',
            'email' => 'required|email|max:191',
            'gender' => 'nullable|integer|min:0|max:1',
            'street' => 'required|max:255',
            'building' => 'required|max:25',
            'entrance' => 'nullable|max:25',
            'house' => 'nullable|max:25',
            'apartment' => 'nullable|max:25',
            'floor' => 'nullable|max:25',
            'current_password' => 'required',
            'password' => 'nullable|min:6|max:191|confirmed',
            'avatar' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:20000',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ( !Hash::check($this->current_password, $this->user()->password) ) {
                $validator->errors()->add('current_password', 'Неправильний пароль');
            }
        });
        return;
    }
}
