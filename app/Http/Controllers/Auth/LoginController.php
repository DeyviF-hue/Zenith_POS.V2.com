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

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$field => $login]);
        return $field;
    }

    // Show login form, preferring Breeze/Jetstream views if installed
    public function showLoginForm()
    {
        // If a Breeze login view exists (resources/views/auth/login.blade.php), use it
        if (view()->exists('auth.login')) {
            return view('auth.login');
        }
        // If Jetstream is installed and provides its own authentication view, prefer it if available
        if (class_exists('\Laravel\Jetstream\JetstreamServiceProvider')) {
            if (view()->exists('auth.login')) {
                return view('auth.login');
            }
        }
        // Fallback to our custom login view
        return view('auth.custom-login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
}
