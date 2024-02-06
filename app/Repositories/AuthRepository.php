<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AuthRepository 
{
  public function __construct(
    protected readonly User $user,
    protected readonly Customer $customer
  ) {}

  public function login($credentials)
  {
    try {   
      if(isset($credentials["remember"]) && !empty($credentials["remember"])) {
        setcookie("username", $credentials["username"], time() + (7 * 24 * 60 * 60));
        setcookie("password", $credentials["password"], time() + (7 * 24 * 60 * 60));        
      } else {
        setcookie("username", "");
        setcookie("password", "");
      }
      $user = $this->user->where("username", $credentials["username"])->first();
      
      if($user->email_verified_at) {
        return auth()->attempt(Arr::except($credentials, "remember"), Arr::only($credentials, "remember"));
      } 

      return false;
    } catch (\Exception $e) {
      logger($e->getMessage());
      setcookie("username", "");
      setcookie("password", "");
      throw $e;
    }            
  } 
  
  public function createUser($data): User
  {
    DB::beginTransaction();     
    try {
      $user = $this->customer->create()
                   ->user()->create($data);
      event(new Registered($user));
      auth()->login($user);

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