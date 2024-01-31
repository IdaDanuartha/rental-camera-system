<?php

namespace App\Repositories;

use App\Models\DeviceType;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeviceTypeRepository
{
  public function __construct(
    protected readonly DeviceType $deviceType,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->deviceType->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->deviceType->latest()->paginate(10);
  }

  public function findById(DeviceType $deviceType): DeviceType
  {
    return $deviceType;
  }

  public function store($request): DeviceType|Exception
  {
    DB::beginTransaction();
    try {
      $deviceType = $this->deviceType->create($request);      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $deviceType;
  }

  public function update($request, DeviceType $deviceType): bool
  {
    DB::beginTransaction();    
    try {        
      $update = $deviceType->updateOrFail($request);			      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(DeviceType $deviceType): bool
  {
    DB::beginTransaction();
    try {
      $delete = $deviceType->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}