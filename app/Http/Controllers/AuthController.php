<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Events\ActiveUsersUpdated;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function attemptLogin(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'required',
            'password' => 'required',
        ]);

        $user = User::where('user_id', $validated['user_id'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            // Store session info
            session([
                'user_id'    => $user->id,
                'user_name'  => $user->user_name,
                'user_level' => $user->user_level,
            ]);

            // Add user to active list with role + name + expiry
            $activeUsers = Cache::get('active_users_list', []);
            $activeUsers[$user->id] = [
                'role'      => $user->user_level,
                'user_name' => $user->user_name,
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

            // Broadcast updated count + breakdown + names
            event(new ActiveUsersUpdated(count($activeUsers), $roleCounts, $roleUsers));

            // Redirect based on role
            return match ($user->user_level) {
                'Admin'   => redirect('/admin'),
                'CE'      => redirect('/engineer'),
                'Manager' => redirect('/manager'),
                'Account' => redirect('/account'),
                'Guest'   => redirect('/guest'),
                default   => redirect('/login')->with('error', 'Unauthorized access.'),
            };
        }

        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        $userId = session('user_id');
        if ($userId) {
            // Remove user from active list
            $activeUsers = Cache::get('active_users_list', []);
            unset($activeUsers[$userId]);

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

            // Broadcast updated count + breakdown + names
            event(new ActiveUsersUpdated(count($activeUsers), $roleCounts, $roleUsers));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
