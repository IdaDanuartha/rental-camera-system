<?php

namespace App\Repositories;

use App\Models\DeviceSeries;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeviceSeriesRepository
{
  public function __construct(
    protected readonly DeviceSeries $deviceSeries,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->deviceSeries->latest()->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->deviceSeries->latest()->with(['deviceBrand'])->paginate(10);
  }

  public function findById(DeviceSeries $deviceSeries): DeviceSeries
  {
    return $this->deviceSeries->where('id', $deviceSeries->id)->with("deviceBrand")->first();
  }

  public function store($request): DeviceSeries|Exception
  {
    DB::beginTransaction();
    try {
      $deviceSeries = $this->deviceSeries->create($request);      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $deviceSeries;
  }

  public function update($request, DeviceSeries $deviceSeries): bool
  {
    DB::beginTransaction();    
    try {        
      $update = $deviceSeries->updateOrFail($request);			      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(DeviceSeries $deviceSeries): bool
  {
    DB::beginTransaction();
    try {
      $delete = $deviceSeries->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}