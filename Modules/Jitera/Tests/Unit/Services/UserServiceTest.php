<?php

namespace Modules\Jitera\Tests\Unit\Services;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Modules\Jitera\Events\FollowedUser;
use Modules\Jitera\Events\UnfollowedUser;
use Modules\Jitera\Services\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private User $follower;
    private UserService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->follower = User::factory()->create();
        $this->service = app(UserService::class);
    }

    public function testFollowUser()
    {
        Event::fake([FollowedUser::class]);

        $followedUser1 = User::factory()->create();
        $followedUser2 = User::factory()->create();

        $this->service->follow($this->follower, $followedUser1);
        $this->service->follow($this->follower, $followedUser2);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $this->follower->id,
            'followed_id' => $followedUser1->id,
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $this->follower->id,
            'followed_id' => $followedUser2->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followedUser1) {
            return $event->followerUser->is($this->follower) && $event->followedUser->is($followedUser1);
        });

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followedUser2) {
            return $event->followerUser->is($this->follower) && $event->followedUser->is($followedUser2);
        });
    }

    public function testUnfollowUser()
    {
        Event::fake([FollowedUser::class, UnfollowedUser::class]);

        $followedUser = User::factory()->create();

        $this->service->follow($this->follower, $followedUser);
        $this->service->unfollow($this->follower, $followedUser);

        $this->assertDatabaseMissing('follows_tables', [
            'follower_id' => $this->follower->id,
            'followed_id' => $followedUser->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followedUser) {
            return $event->followerUser->is($this->follower) && $event->followedUser->is($followedUser);
        });

        Event::assertDispatched(UnfollowedUser::class, function ($event) use ($followedUser) {
            return $event->followerUser->is($this->follower) && $event->followedUser->is($followedUser);
        });
    }

    public function testSearchFollowers()
    {
        $followedUser1 = User::factory()->create(['name' => $this->faker->name]);
        $followedUser2 = User::factory()->create(['name' => $this->faker->name]);

        $this->service->follow($this->follower, $followedUser1);
        $this->service->follow($this->follower, $followedUser2);

        $followers = $this->service->getFollowers($this->follower);
        $this->assertCount(2, $followers);
    }

    public function testSearchFollowersByName()
    {
        $followedUser1 = User::factory()->create(['name' => $this->faker->name]);
        $followedUser2 = User::factory()->create(['name' => 'John Doe']);

        $this->service->follow($this->follower, $followedUser1);
        $this->service->follow($this->follower, $followedUser2);

        $followers = $this->service->getFollowers($this->follower, 'John');
        $this->assertCount(1, $followers);

        $this->assertTrue($followers->first()->is($followedUser2));
    }
}
