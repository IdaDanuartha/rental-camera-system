<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepository;

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
            $this->authRepository->login($request->validated());

            return redirect()->route("dashboard.index")->with('success', 'Login success! Welcome back ' . auth()->user()->username);                    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Login failed! Check your credentials and try again');
        }
    }
}
