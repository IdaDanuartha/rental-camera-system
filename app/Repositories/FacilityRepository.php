<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Facility;
use App\Models\FacilityImage;
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
    protected readonly FacilityImage $facilityImage,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->facility->latest()->with(['facilityType', 'facilityImages'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->facility->latest()->with(['facilityType', 'facilityImages'])->paginate(10);
  }

  public function findById(Facility $facility): Facility
  {
    return $this->facility->where('id', $facility->id)->with(['facilityType', 'facilityImages'])->first();
  }

  public function findImageDeleted($facility_id, $image_deleted): Collection
  {
    return $this->facilityImage->where('facility_id', $facility_id)->whereIn("id", explode(",", $image_deleted["image_deleted"]))->get(); 
  }

  public function store($request): Facility|Exception
  {
    DB::beginTransaction();
    try {   
      $facility = $this->facility->create(Arr::except($request, "images"));
      
      foreach($request["images"] as $image) {
        $filename = $this->uploadFile->uploadSingleFile($image, "facilities");
        $this->facilityImage->create([
          "facility_id" => $facility->id,
          "image" => $filename
        ]);
      }

    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $facility;
  }

  public function update($request, Facility $facility): bool
  {
    DB::beginTransaction();    
    try {  
      if(Arr::get($request, "image_deleted")) {
        foreach($this->findImageDeleted($facility->id, Arr::only($request, "image_deleted")) as $image) {                      
          $this->uploadFile->deleteExistFile("facilities/$image->image");        
          $image->delete();
        } 
      }
      
      foreach($request["images"] as $image) {
        $filename = $this->uploadFile->uploadSingleFile($image, "facilities");
        $this->facilityImage->create([
          'facility_id' => $facility->id,
          'image' => $filename
        ]);
      }

      $facility_updated = $facility->updateOrFail($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $facility_updated;
  }

  public function delete(Facility $facility): bool
  {
    DB::beginTransaction();
    try {
      foreach($facility->facilityImages as $image) {                              
        $this->uploadFile->deleteExistFile("facilities/$image->image");
        $image->delete();
      } 

      $delete_facility = $facility->deleteOrFail();
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete_facility;
  }
}