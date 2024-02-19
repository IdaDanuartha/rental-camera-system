<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Customer;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
  public function __construct(
    protected readonly Customer $customer,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->customer->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->customer->latest()->with(['user'])->paginate(10);
  }

  public function findById(Customer $customer): Customer
  {
    return $customer;
  }

  public function store($request): Customer|Exception
  {
    DB::beginTransaction();
    try {  
      if ($request["profile_image"]) {         
        $filename = $this->uploadFile->uploadSingleFile($request['profile_image'], "users");
        $request['profile_image'] = $filename;
      }  

      $customer = $this->customer->create(Arr::only($request, ['name', 'phone_number', 'profile_image']));
      $customer->user()->create([
        'username' => Arr::get($request, 'user.username'),
        'email' => Arr::get($request, 'user.email'),
        'password' => Arr::get($request, 'user.password'),
        'status' => Arr::has($request, 'user.status') ? UserStatus::ACTIVE : UserStatus::NONACTIVE,
        'role' => Role::CUSTOMER
      ]);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $customer;
  }

  public function update($request, Customer $customer): bool
  {
    DB::beginTransaction();    
    try {  
      if (Arr::has($request, 'profile_image') && Arr::get($request, 'profile_image')) {
        $this->uploadFile->deleteExistFile("users/$customer->profile_image");

        $image = Arr::get($request, 'profile_image');

        $filename = $this->uploadFile->uploadSingleFile($image, "users");
        $request['profile_image'] = $filename;
      }  

      if(Arr::get($request, 'user.status')) $request['user']['status'] = UserStatus::ACTIVE;			
      else $request['user']['status'] = UserStatus::NONACTIVE;
      
      if(is_null(Arr::get($request, 'user.password'))) Arr::pull($request, 'user.password');			

      $customer->updateOrFail(Arr::only($request, ['name', 'phone_number', 'profile_image']));
			$customer->user->updateOrFail(Arr::get($request, 'user'));

      DB::commit();
      return true;

    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
  }

  public function delete(Customer $customer): bool
  {
    DB::beginTransaction();
    try {
      $this->uploadFile->deleteExistFile("users/$customer->profile_image");

      $customer->user?->deleteOrFail();
      $delete_customer = $customer->deleteOrFail();
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete_customer;
  }
}