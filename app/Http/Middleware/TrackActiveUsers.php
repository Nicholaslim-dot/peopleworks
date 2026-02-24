<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use App\Events\ActiveUsersUpdated;

class TrackActiveUsers
{
    public function handle($request, Closure $next)
    {
        if (session()->has('user_id')) {
            $userId    = session('user_id');
            $userName  = session('user_name');
            $userLevel = session('user_level'); // Admin, CE, Manager, etc.

            // Maintain a list of active users with role + name + expiry
            $activeUsers = Cache::get('active_users_list', []);

            $activeUsers[$userId] = [
                'role'      => $userLevel,
                'user_name' => $userName,
                'expiry'    => now()->addMinutes(30),
            ];

            // Remove expired entries
            $activeUsers = array_filter($activeUsers, fn($data) => $data['expiry']->isFuture());

            Cache::put('active_users_list', $activeUsers, now()->addMinutes(30));

            // Build role breakdown + names
            $roleCounts = [];
            $roleUsers  = [];
            foreach ($activeUsers as $data) {
                $roleCounts[$data['role']] = ($roleCounts[$data['role']] ?? 0) + 1;
                $roleUsers[$data['role']][] = $data['user_name'];
            }

            // Broadcast updated counts + names
            event(new ActiveUsersUpdated(count($activeUsers), $roleCounts, $roleUsers));
        }

        return $next($request);
    }
}
