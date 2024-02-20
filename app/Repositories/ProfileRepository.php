<?php

namespace App\Repositories;

use App\Enums\UserStatus;
use App\Models\User;
use App\Utils\UploadFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProfileRepository
{
  public function __construct(
    protected readonly User $user,
    protected readonly UploadFile $uploadFile
  ) {}

  public function update($request): bool
  {
    DB::beginTransaction();    
    try {    
        $user = $this->user->find(auth()->id());

        if (Arr::has($request, 'profile_image') && Arr::get($request, 'profile_image')) {
            $this->uploadFile->deleteExistFile("users/" . auth()->user()->profile_image);
    
            $image = Arr::get($request, 'profile_image');
    
            $filename = $this->uploadFile->uploadSingleFile($image, "users");
            $request['profile_image'] = $filename;
        }  
              
        if(is_null(Arr::get($request, 'user.password'))) Arr::pull($request, 'user.password');			
    
        $user->authenticatable->updateOrFail(Arr::except($request, "user"));
        $user_updated = $user->updateOrFail(Arr::get($request, "user"));
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $user_updated;
  }
}