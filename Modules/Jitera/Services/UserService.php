<?php

namespace Modules\Jitera\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;
use Modules\Jitera\Events\FollowedUser;
use Modules\Jitera\Events\UnfollowedUser;

class UserService
{
    public function follow(User $followerUser, User $followedUser): void
    {
        $followerUser->followings()->attach($followedUser);

        Event::dispatch(new FollowedUser($followerUser, $followedUser));
    }

    public function unfollow(User $followerUser, User $followedUser): void
    {
        $followerUser->followings()->detach($followedUser);

        Event::dispatch(new UnfollowedUser($followerUser, $followedUser));
    }

    public function getFollowers(User $user, ?string $search = null): Collection
    {
        if ($search === null) {
            return $user->followings;
        }

        return $user->followings()->where('name', 'like', "%{$search}%")->get();
    }
}
