<?php

namespace App\Http\Requests\v1\products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'data.type' => 'required|in:products',
            'data.attributes' => 'required|array',
            'data.attributes.name' => 'required|max:30|string|unique:products,name', 
            'data.attributes.is_enable' => 'sometimes|boolean',
            'data.attributes.description' => 'sometimes|max:200',
            'data.attributes.costo' => 'sometimes|numeric|min:0',
            'data.attributes.porc_min' => 'sometimes|numeric|min:0',
            'data.attributes.porc_may' => 'sometimes|numeric|min:0',
            'data.relationships.category.data.id' => 'required|exists:categories,id'           
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.name.required' => 'The Name field is required.',
            'data.attributes.name.max' => 'The Name must not be greater than 30 characters.',
            'data.attributes.name.unique' => 'The name has already been taken.', 

            'data.attributes.description.max' => 'The Description must not be greater than 200 characters.',

            'data.attributes.costo.numeric' => 'The costo field must be numeric',
            'data.attributes.costo.min' => 'The costo field must be at least 0',

            'data.attributes.porc_min.numeric' => 'The porc_min field must be numeric',
            'data.attributes.porc_min.min' => 'The porc_min field must be at least 0',

            'data.attributes.porc_may.numeric' => 'The porc_may field must be numeric',
            'data.attributes.porc_may.min' => 'The porc_may field must be at least 0',

            'data.relationships.category.data.id.exists' => 'The category id is invalid.',            
        ];
    }
}
