<?php

namespace App\Repositories;

use App\Models\FacilityCart;
use App\Models\Product;
use App\Utils\UploadFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FacilityCartRepository
{
  public function __construct(
    protected readonly FacilityCart $facilityCart,
    protected readonly Product $product,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->facilityCart->with(["user", "facility.facilityImages"])->where("user_id", auth()->id())->latest()->get();
  }

  public function findById(FacilityCart $facilityCart): FacilityCart
  {
    return $this->facilityCart->where('id', $facilityCart->id)->with(["user", "facility.facilityImages"])->first();
  }

  public function store($facility_id): FacilityCart|bool|Exception
  {
    DB::beginTransaction();
    try {        
      $facility_cart = $this->facilityCart->where('user_id', auth()->id())->where("facility_id", $facility_id)->first();

      if(!$facility_cart) {
        $facilityCart = $this->facilityCart->create([
          "facility_id" => $facility_id,
          "user_id" => auth()->id()
        ]);

        DB::commit();
        return $facilityCart;
      } else {
        $facility_cart->qty += 1;
        $facility_cart->return_date = Carbon::createFromDate($facility_cart->return_date)->addDays();
        $facility_cart->update();

        DB::commit();
        return $facility_cart;
      }
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
  }

  public function changeBookingDate($request, FacilityCart $facilityCart): bool
  {
    DB::beginTransaction();    
    try {  
      $update = $facilityCart->updateOrFail([
        "qty" => Arr::get($request, "total_days"),
        "booking_date" => Arr::get($request, "start_date"),
        "return_date" => Arr::get($request, "end_date"),
      ]);

    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(FacilityCart $facilityCart): bool
  {
    DB::beginTransaction();
    try {
      $delete = $facilityCart->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}