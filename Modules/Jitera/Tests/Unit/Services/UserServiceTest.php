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
    public function testFollowUser()
    {
        Event::fake([FollowedUser::class]);
        $service = app(UserService::class);

        $followerUser = User::factory()->create();
        $followedUser1 = User::factory()->create();
        $followedUser2 = User::factory()->create();

        $service->follow($followerUser, $followedUser1);
        $service->follow($followerUser, $followedUser2);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $followedUser1->id,
        ]);

        $this->assertDatabaseHas('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $followedUser2->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followerUser, $followedUser1) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $followedUser1->id;
        });

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followerUser, $followedUser2) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $followedUser2->id;
        });
    }

    public function testUnfollowUser()
    {
        Event::fake([FollowedUser::class, UnfollowedUser::class]);
        $service = app(UserService::class);

        $followerUser = User::factory()->create();
        $followedUser = User::factory()->create();

        $service->follow($followerUser, $followedUser);
        $service->unfollow($followerUser, $followedUser);

        $this->assertDatabaseMissing('follows_tables', [
            'follower_id' => $followerUser->id,
            'followed_id' => $followedUser->id,
        ]);

        Event::assertDispatched(FollowedUser::class, function ($event) use ($followerUser, $followedUser) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $followedUser->id;
        });

        Event::assertDispatched(UnfollowedUser::class, function ($event) use ($followerUser, $followedUser) {
            return $event->followerUser->id === $followerUser->id && $event->followedUser->id === $followedUser->id;
        });
    }

    public function testSearchFollowings()
    {
        $service = app(UserService::class);

        $followerUser = User::factory()->create();
        $followedUser = User::factory()->create(['name' => 'John Doe']);

        $service->follow($followerUser, $followedUser);

        $this->assertTrue($service->searchFollowings($followerUser, 'John')->first()->is($followedUser));
    }
}
