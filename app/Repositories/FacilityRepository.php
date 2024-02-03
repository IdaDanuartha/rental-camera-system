<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Facility;
use App\Models\Product;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FacilityRepository
{
  public function __construct(
    protected readonly Facility $facility,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->facility->latest()->with(['facilityType'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->facility->latest()->with(['facilityType'])->paginate(10);
  }

  public function findById(Facility $facility): Facility
  {
    return $this->facility->where('id', $facility->id)->with(['facilityType'])->first();
  }

  public function store($request): Facility|Exception
  {
    DB::beginTransaction();
    try {  
      $product = $this->facility->create($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $product;
  }

  public function update($request, Facility $facility): bool
  {
    DB::beginTransaction();    
    try {  
      $facility->updateOrFail($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return true;
  }

  public function delete(Facility $facility): bool
  {
    DB::beginTransaction();
    try {
      $delete_product = $facility->deleteOrFail();
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete_product;
  }
}