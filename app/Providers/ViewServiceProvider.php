<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $activeUsers = Cache::get('active_users_list', []);

            // Remove expired entries
            $activeUsers = array_filter($activeUsers, fn($data) => $data['expiry']->isFuture());

            $count = count($activeUsers);

            // Build role breakdown with names
            $roleCounts = [];
            $roleUsers  = [];
            foreach ($activeUsers as $data) {
                $roleCounts[$data['role']] = ($roleCounts[$data['role']] ?? 0) + 1;
                if (isset($data['user_name'])) {
                    $roleUsers[$data['role']][] = $data['user_name'];
                }
            }

            $view->with([
                'activeUsers' => $count,
                'roleCounts'  => $roleCounts,
                'roleUsers'   => $roleUsers,
            ]);
        });
    }
}
