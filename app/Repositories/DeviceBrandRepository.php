<?php

namespace App\Repositories;

use App\Models\DeviceBrand;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeviceBrandRepository
{
  public function __construct(
    protected readonly DeviceBrand $deviceBrand,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->deviceBrand->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->deviceBrand->latest()->with(['deviceType'])->paginate(10);
  }

  public function findById(DeviceBrand $deviceBrand): DeviceBrand
  {
    return $this->deviceBrand->where('id', $deviceBrand->id)->with("deviceType")->first();
  }

  public function store($request): DeviceBrand|Exception
  {
    DB::beginTransaction();
    try {
      $deviceBrand = $this->deviceBrand->create($request);      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $deviceBrand;
  }

  public function update($request, DeviceBrand $deviceBrand): bool
  {
    DB::beginTransaction();    
    try {        
      $update = $deviceBrand->updateOrFail($request);			      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(DeviceBrand $deviceBrand): bool
  {
    DB::beginTransaction();
    try {
      $delete = $deviceBrand->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}