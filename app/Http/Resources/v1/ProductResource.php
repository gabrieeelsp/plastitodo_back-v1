<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'product',
            'attributes' => [
                'name' => $this->name,
                'is_enable' => boolval($this->is_enable),
                'description' => $this->description,
                'costo' => $this->costo,
                'porc_min' => $this->porc_min,
                'porc_may' => $this->porc_may,
                'created_at' => $this->created_at->addHours(-3),
                'updated_at' => $this->updated_at->addHours(-3),
            ]
             ,
            'relationships' => [
                'category' => [
                    'data' => [
                        'id' => $this->category_id,
                        'type' => 'categories',
                        'attributes' => [
                            'name' => $this->when( $request->has('include_category_name') && $request->get('include_category_name') == 'true' ,
                            $this->category->name)
                        ]
                    ]
                ]
            ]
        ];    
        //return parent::toArray($request);
    }
}
