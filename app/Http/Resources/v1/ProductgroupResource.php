<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductgroupResource extends JsonResource
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
            'type' => 'productgroup',
            'attributes' => [
                'name' => $this->name,
                'created_at' => $this->created_at->addHours(-3),
                'updated_at' => $this->updated_at->addHours(-3),
            ]
        ];    
        //return parent::toArray($request);
    }
}
