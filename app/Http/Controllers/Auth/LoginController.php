<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function redirectTo()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return '/admin';
        } elseif ($user->role === 'courier') {
            return '/courier';
        } elseif ($user->role === 'customer') {
            return '/customer';
        }

        return '/';
    }
}
