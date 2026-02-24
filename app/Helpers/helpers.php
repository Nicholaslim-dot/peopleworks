<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('homeRoute')) {
    function homeRoute()
    {
        switch (Session::get('user_level')) {
            case 'Admin':
                return url('/admin');
            case 'Manager':
                return url('/manager');
            case 'Account':
                return url('/account');
            case 'CE':
                return url('/engineer');
            case 'Guest':
                return url('/guest');
            default:
                return url('/login');
        }
    }
}
