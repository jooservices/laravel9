<?php

namespace Modules\Jitera\Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Modules\Jitera\Events\FollowedUser;
use Modules\Jitera\Events\UnfollowedUser;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private User $followedUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->followedUser = User::factory()->create();
    }

    public function testFollow()
    {
        Event::fake([FollowedUser::class]);

        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$this->followedUser->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $this->followedUser->id,
                ],
            ],
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $this->followedUser->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followerUser) {
            return $event->followerUser->is($followerUser) && $event->followedUser->is($this->followedUser);
        });
    }

    public function testUnfollow()
    {
        Event::fake([FollowedUser::class, UnfollowedUser::class]);

        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$this->followedUser->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $this->followedUser->id,
                ],
            ],
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $this->followedUser->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followerUser) {
            return $event->followerUser->is($followerUser) && $event->followedUser->is($this->followedUser);
        });

        $this->post(
            '/api/v1/users/'.$this->followedUser->id.'/unfollow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $this->followedUser->id,
                ],
            ],
        ]);

        $this->assertDatabaseMissing('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $this->followedUser->id,
        ]);

        Event::assertDispatched(UnfollowedUser::class, function ($event) use ($followerUser) {
            return $event->followerUser->is($followerUser) && $event->followedUser->is($this->followedUser);
        });
    }

    public function testGetFollows()
    {
        $followerUser = User::factory()->create();
        $this->post(
            '/api/v1/users/'.$this->followedUser->id.'/follow',
            [
                'follower_user_id' => $followerUser->id,
            ]
        )->assertJson([
            'status' => true,
            'data' => [
                'properties' => [
                    'id' => $this->followedUser->id,
                ],
            ],
        ]);

        $this->get(
            '/api/v1/users/'.$followerUser->id.'/followings',
            [
                'name' => $this->followedUser->name,
            ]
        )
            ->assertStatus(200)
            ->assertJsonPath('data.0.properties.id', $this->followedUser->id);
    }
}
