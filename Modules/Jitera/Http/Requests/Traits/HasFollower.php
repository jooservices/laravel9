<?php

namespace Modules\Jitera\Http\Requests\Traits;

use App\Models\User;

trait HasFollower
{
    public function getFollowerUser(): User
    {
        return User::find($this->input('follower_user_id'));
    }
}
