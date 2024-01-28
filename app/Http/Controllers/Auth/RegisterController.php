<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;

class RegisterController extends Controller
{
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {}

    public function signup()
    {
        return view('auth.signup');
    }
    
    public function createAccount(RegisterRequest $request)
    {
        try {
            $this->authRepository->createUser($request->except("confirm_password"));
            
            return redirect()->route("login")->with('success', 'Account created successfully. Please login!');
        } catch (\Exception $e) {
            logger($e->getMessage());

            return redirect()->back()->with('error', 'Failed to create account');
        }
    }
}
