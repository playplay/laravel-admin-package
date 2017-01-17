<?php

namespace MathieuTu\LaravelAdminPackage\App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use MathieuTu\LaravelAdminPackage\app\Http\Controllers\Controller;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    // if not logged in redirect to
    protected $loginPath;
    // after you've logged in redirect to
    protected $redirectTo;
    // after you've logged out redirect to
    protected $redirectAfterLogout;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->loginPath = route('admin.auth.login');
        $this->redirectTo = route('admin.home');
        $this->redirectAfterLogout = route('admin.home');
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin::auth.login');
    }
}
