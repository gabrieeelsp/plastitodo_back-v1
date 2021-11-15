<?php

namespace App\Http\Requests\v1\products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSetCategoryRequest extends FormRequest
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
            'data.relationships.category.data.id' => 'required|exists:categories,id' 
        ];
    }

    public function messages()
    {
        return [


            'data.relationships.category.data.id.exists' => 'The category id is invalid.',            
        ];
    }
}
