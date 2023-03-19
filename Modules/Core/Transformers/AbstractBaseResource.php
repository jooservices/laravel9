<?php

namespace Modules\Core\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractBaseResource extends JsonResource
{
    protected array $data;

    abstract protected function getLinks(): array;

    abstract protected function getProperties(): array;

    abstract protected function getType(): string;

    public function toArray($request): array
    {
        return [
            'type' => get_class($this->resource),
            'properties' => $this->getProperties(),
            'links' => $this->getLinks(),
        ];
    }
}
