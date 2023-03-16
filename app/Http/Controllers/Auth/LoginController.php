<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'per_login';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //PARA PERMITIR SOLO A LOS ACTIVOS
    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['per_login' => $request->{$this->username()}, 'password' => $request->password, 'estado' => 1];
    }
}
