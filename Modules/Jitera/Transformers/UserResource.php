<?php

namespace Modules\Jitera\Transformers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type'=> User::class,
            'properties' => [
                'id' => $this->id,
                'name' => $this->name,
            ],
            'links' => [
                'self' => route('jitera.users.show', $this),
            ],
        ];
    }
}
