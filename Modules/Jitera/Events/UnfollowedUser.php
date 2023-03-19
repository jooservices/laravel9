<?php

namespace Modules\Jitera\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UnfollowedUser
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $followerUser, public User $followedUser)
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
