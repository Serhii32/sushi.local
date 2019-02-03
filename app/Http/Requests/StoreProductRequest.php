<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
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
            'title' => 'required|min:3|max:191',
            'price' => 'required|numeric|min:0.00|max:100000000.00',
            'weight' => 'nullable|numeric|min:0|max:100000000',
            'category_id' => 'integer|nullable',
            'titleSEO' => 'max:255',
            'descriptionSEO' => 'max:1000',
            'keywordsSEO' => 'max:255',
            'photo' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:20000',
        ];
    }
}
