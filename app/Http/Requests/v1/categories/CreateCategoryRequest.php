<?php

namespace App\Http\Requests\v1\categories;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'data' => 'required|array',
            'data.type' => 'required|in:categories',
            'data.attributes' => 'required|array',
            'data.attributes.name' => 'required|max:30|string|unique:categories,name', 
            'data.attributes.is_enable' => 'sometimes|boolean',            
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.name.required' => 'The Name field is required.',
            'data.attributes.name.max' => 'The Name must not be greater than 30 characters.',
            'data.attributes.name.unique' => 'The name has already been taken.',            
        ];
    }
}
