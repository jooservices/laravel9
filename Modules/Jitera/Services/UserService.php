<?php

namespace Modules\Jitera\Services;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Modules\Jitera\Events\FollowedUser;
use Modules\Jitera\Events\UnfollowedUser;

class UserService
{
    public function follow(User $followerUser, User $followedUser)
    {
        $followerUser->followings()->attach($followedUser);

        Event::dispatch(new FollowedUser($followerUser, $followedUser));
    }

    public function unfollow(User $followerUser, User $followedUser)
    {
        $followerUser->followings()->detach($followedUser);

        Event::dispatch(new UnfollowedUser($followerUser, $followedUser));
    }

    public function searchFollowers(User $user, ?string $search = null)
    {
        if ($search === null) {
            return $user->followings;
        }

        return $user->followings()->where('name', 'like', "%{$search}%")->get();
    }
}
