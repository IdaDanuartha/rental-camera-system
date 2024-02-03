<?php

namespace App\Repositories;

use App\Models\DeviceType;
use App\Models\FacilityType;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FacilityTypeRepository
{
  public function __construct(
    protected readonly FacilityType $facilityType,
  ) {}

  public function findAll(): Collection
  {
    return $this->facilityType->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->facilityType->latest()->paginate(10);
  }

  public function findById(FacilityType $facilityType): FacilityType
  {
    return $facilityType;
  }

  public function store($request): FacilityType|Exception
  {
    DB::beginTransaction();
    try {
      $deviceType = $this->facilityType->create($request);      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $deviceType;
  }

  public function update($request, FacilityType $facilityType): bool
  {
    DB::beginTransaction();    
    try {        
      $update = $facilityType->updateOrFail($request);			      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(FacilityType $facilityType): bool
  {
    DB::beginTransaction();
    try {
      $delete = $facilityType->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}