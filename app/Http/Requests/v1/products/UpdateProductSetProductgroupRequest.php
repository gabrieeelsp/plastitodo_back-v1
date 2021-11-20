<?php

namespace App\Http\Requests\v1\products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductSetProductgroupRequest extends FormRequest
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
            'data.relationships.productgroup.data.id' => 'required|exists:productgroups,id' 
        ];
    }

    public function messages()
    {
        return [


            'data.relationships.productgroup.data.id.exists' => 'The category id is invalid.',            
        ];
    }
}
