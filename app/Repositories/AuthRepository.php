<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthRepository 
{
  public function __construct(
    protected readonly User $user
  ) {}

  public function login($credentials)
  {
    try {
      return auth()->attempt($credentials);
    } catch (\Exception $e) {
      logger($e->getMessage());
      throw $e;
    }            
  } 
  
  public function createUser($data): User
  {
    DB::beginTransaction();     
    try {
      $user = $this->user->create($data);
      DB::commit();

      return $user;
    } catch (\Exception $e) {
      DB::rollBack();
      logger($e->getMessage());
      
      throw $e;
    } 
  }

  public function logout($request): bool
  {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return true;
  }
}