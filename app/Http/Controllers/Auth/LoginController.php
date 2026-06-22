<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/pegawai';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Custom redirect berdasarkan role pengguna.
     */
    public function redirectTo()
    {
        // Anda bisa mengarahkan ke halaman yang berbeda jika role-nya admin
        if (auth()->user()->role == 'admin') {
            return '/pegawai'; // Arahkan ke halaman admin jika diperlukan
        }

        // Default redirect untuk operator atau role lain
        return '/pegawai';
    }
}