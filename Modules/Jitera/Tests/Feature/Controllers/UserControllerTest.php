<?php

namespace Modules\Jitera\Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Modules\Jitera\Events\FollowedUser;
use Modules\Jitera\Events\UnfollowedUser;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testFollow()
    {
        Event::fake([FollowedUser::class]);

        $user = User::factory()->create();
        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$user->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $user->id,
                ],
            ],
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $user->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($user, $followerUser) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $user->id;
        });
    }

    public function testUnfollow()
    {
        Event::fake([FollowedUser::class, UnfollowedUser::class]);

        $user = User::factory()->create();
        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$user->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $user->id,
                ],
            ],
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $user->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($user, $followerUser) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $user->id;
        });

        $this->post(
            '/api/v1/users/'.$user->id.'/unfollow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $user->id,
                ],
            ],
        ]);

        $this->assertDatabaseMissing('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $user->id,
        ]);

        Event::assertDispatched(UnfollowedUser::class, function ($event) use ($user, $followerUser) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $user->id;
        });
    }

    public function testGetFollows()
    {
        $user = User::factory()->create();
        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$user->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $user->id,
                ],
            ],
        ]);

        $this->get(
            '/api/v1/users/'.$followerUser->id.'/followings',
            [
                'name' => $user->name,
            ]
        )
            ->assertStatus(200)
            ->assertJsonPath('data.0.properties.id', $user->id);
    }
}
