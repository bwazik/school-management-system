<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');

        $this->redirectTo = $this->setRedirectPath();
    }

    protected function setRedirectPath()
    {
        $guard = request()->route('guard');
        switch ($guard) {
            case 'admin':
                return '/admin/dashboard';
            case 'student':
                return '/student/dashboard';
            case 'teacher':
                return '/teacher/dashboard';
            case 'parent':
                return '/parent/dashboard';
            default:
                return '/';
        }
    }
}
