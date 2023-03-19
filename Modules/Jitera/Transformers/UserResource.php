<?php

namespace Modules\Jitera\Transformers;

use App\Models\User;
use Modules\Core\Transformers\AbstractBaseResource;

class UserResource extends AbstractBaseResource
{
    protected function getType(): string
    {
        return User::class;
    }

    protected function getProperties(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    protected function getLinks(): array
    {
        return [
            'self' => route('jitera.users.show', $this),
        ];
    }
}
