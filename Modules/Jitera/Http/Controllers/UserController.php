<?php

namespace Modules\Jitera\Http\Controllers;

use App\Models\User;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Jitera\Http\Requests\FollowUser;
use Modules\Jitera\Http\Requests\GetFollowerUsers;
use Modules\Jitera\Http\Requests\UnfollowUser;
use Modules\Jitera\Services\UserService;
use Modules\Jitera\Transformers\UserResource;

class UserController extends ApiController
{
    public function follow(FollowUser $request, User $user, UserService $userService)
    {
        $followerUser = User::find($request->follower_user_id);

        $userService->follow($followerUser, $user);

        return $this->respondOk(UserResource::make($user));
    }

    public function unfollow(UnfollowUser $request, User $user, UserService $userService)
    {
        $followerUser = User::find($request->follower_user_id);

        $userService->unfollow($followerUser, $user);

        return $this->respondOk(UserResource::make($user));
    }

    public function follows(GetFollowerUsers $request, User $user, UserService $userService)
    {
        return $this->respondOk(
            UserResource::collection($userService->getFollowers($user, $request->input('name')))
        );
    }
}
