<?php

namespace Modules\ATG\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' =>  $this->uuid,
            'name' =>  $this->name,
            'manufacturer' =>  $this->manufacturer,
            'model' =>  $this->model,
            'price' =>  $this->price,
        ];
    }
}
