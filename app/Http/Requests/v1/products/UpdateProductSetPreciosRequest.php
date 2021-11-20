<?php

namespace App\Http\Requests\v1\products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSetPreciosRequest extends FormRequest
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
            'data.attributes.costo' => 'sometimes|numeric|min:0',
            'data.attributes.porc_min' => 'sometimes|numeric|min:0',
            'data.attributes.porc_may' => 'sometimes|numeric|min:0',
            'data.attributes.edit_group' => 'sometimes|boolean',         
        ];
    }

    public function messages()
    {
        return [

            'data.attributes.costo.numeric' => 'The costo field must be numeric',
            'data.attributes.costo.min' => 'The costo field must be at least 0',

            'data.attributes.porc_min.numeric' => 'The porc_min field must be numeric',
            'data.attributes.porc_min.min' => 'The porc_min field must be at least 0',

            'data.attributes.porc_may.numeric' => 'The porc_may field must be numeric',
            'data.attributes.porc_may.min' => 'The porc_may field must be at least 0',
          
        ];
    }
}
