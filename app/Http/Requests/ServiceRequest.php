<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            // 'service_id'=>'required',
            // 'attribute_id'=>'required|integer|min:0',
            // 'value_id'=>'required|integer'

            // 'attributes.*.name' => 'required|string|max:255',
            // 'attributes.*.value' => 'required|string|max:255',
        ];
    }
}
