<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActiveUsersUpdated implements ShouldBroadcast
{
    public $count;
    public $roleCounts;
    public $roleUsers;

    public function __construct($count, $roleCounts, $roleUsers)
    {
        $this->count      = $count;
        $this->roleCounts = $roleCounts;
        $this->roleUsers  = $roleUsers;
    }

    public function broadcastOn()
    {
        return new Channel('admin-dashboard');
    }
}
