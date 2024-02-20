<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Staff;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StaffRepository
{
  public function __construct(
    protected readonly Staff $staff,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Staff
  {
    return $this->staff->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->staff->latest()->with(['user'])->paginate(10);
  }

  public function findById(Staff $staff): Staff
  {
    return $staff;
  }

  public function store($request): Staff|Exception
  {
    DB::beginTransaction();
    try {  
      if ($request["profile_image"]) {         
        $filename = $this->uploadFile->uploadSingleFile($request['profile_image'], "users");
        $request['profile_image'] = $filename;
      }  

      $staff = $this->staff->create(Arr::only($request, ['name', 'phone_number', 'profile_image']));
      $staff->user()->create([
        'username' => Arr::get($request, 'user.username'),
        'email' => Arr::get($request, 'user.email'),
        'password' => Arr::get($request, 'user.password'),
        'status' => Arr::has($request, 'user.status') ? UserStatus::ACTIVE : UserStatus::NONACTIVE,
        'role' => Role::STAFF
      ]);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $staff;
  }

  public function update($request, Staff $staff): bool
  {
    DB::beginTransaction();    
    try {  
      if (Arr::has($request, 'profile_image') && Arr::get($request, 'profile_image')) {
        $this->uploadFile->deleteExistFile("users/$staff->profile_image");

        $image = Arr::get($request, 'profile_image');

        $filename = $this->uploadFile->uploadSingleFile($image, "users");
        $request['profile_image'] = $filename;
      }  

      if(Arr::get($request, 'user.status')) $request['user']['status'] = UserStatus::ACTIVE;			
      else $request['user']['status'] = UserStatus::NONACTIVE;
      
      if(is_null(Arr::get($request, 'user.password'))) Arr::pull($request, 'user.password');			

      $staff->updateOrFail(Arr::only($request, ['name', 'phone_number', 'profile_image']));
			$staff->user->updateOrFail(Arr::get($request, 'user'));

      DB::commit();
      return true;

    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
  }

  public function delete(Staff $staff): bool
  {
    DB::beginTransaction();
    try {
      $this->uploadFile->deleteExistFile("users/$staff->profile_image");

      $staff->user?->deleteOrFail();
      $delete_staff = $staff->deleteOrFail();
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete_staff;
  }
}