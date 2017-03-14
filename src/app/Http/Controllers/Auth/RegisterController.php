<?php

namespace LaravelAdminPackage\App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;
use LaravelAdminPackage\App\Http\Controllers\BaseController;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo;
    /**
     * @var \Illuminate\Validation\Factory
     */
    private $validator;
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable | \Illuminate\Database\Eloquent\Model
     */
    private $model;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Validation\Factory $validator
     */
    public function __construct(Validator $validator)
    {
        $this->middleware('guest');

        $this->redirectTo = route('admin.home');
        $this->validator = $validator;
        $this->model = config('admin.user_model_fqn');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $this->checkIfRegistrationIsOpen();

        return view('admin::auth.register');
    }

    /**
     * If registration is closed, deny access
     */
    private function checkIfRegistrationIsOpen()
    {
        if (!config('admin.is_registration_open')) {
            abort(403, 'Les inscription sont fermées !');
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->checkIfRegistrationIsOpen();

        $this->validator($request->all())->validate();

        $this->guard()->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        $table = (new $this->model)->getTable();

        return $this->validator->make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:' . $table,
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function create(array $data)
    {
        return call_user_func($this->model . '::create', [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
