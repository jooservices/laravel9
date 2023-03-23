<?php

namespace Modules\Jitera\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Jitera\Http\Requests\FollowUser;
use Modules\Jitera\Http\Requests\GetFollowerUsers;
use Modules\Jitera\Http\Requests\UnfollowUser;
use Modules\Jitera\Services\UserService;
use Modules\Jitera\Transformers\UserResource;

class UserController extends ApiController
{
    public function follow(FollowUser $request, User $user, UserService $userService): JsonResponse
    {
        $userService->follow($request->getFollowerUser(), $user);

        return $this->respondOk(UserResource::make($user));
    }

    public function unfollow(UnfollowUser $request, User $user, UserService $userService): JsonResponse
    {
        $userService->unfollow($request->getFollowerUser(), $user);

        return $this->respondOk(UserResource::make($user));
    }

    public function follows(GetFollowerUsers $request, User $user, UserService $userService): JsonResponse
    {
        return $this->respondOk(
            UserResource::collection($userService->getFollowers($user, $request->input('name')))
        );
    }
}
