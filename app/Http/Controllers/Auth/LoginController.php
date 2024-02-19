<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepository;
use Exception;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {}

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $login = $this->authRepository->login($request->validated());

            if($login) {
                return redirect()->route("dashboard.index")->with('success', 'Login success! Welcome back ' . auth()->user()->username);  
            } else if($login == false) {
                return back()->with('not_verified', 'Your email has not been verified! ');  
            } else {
                throw new Exception();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Login failed! Check your credentials and try again');
        }
    }
}
