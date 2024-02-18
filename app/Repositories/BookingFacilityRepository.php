<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingFacility;
use App\Models\BookingFacilityDetail;
use App\Models\DeviceBrand;
use App\Models\FacilityCart;
use App\Models\ProductCart;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingFacilityRepository
{
  public function __construct(
    protected readonly BookingFacility $booking,
    protected readonly BookingFacilityDetail $bookingDetail,
    protected readonly FacilityCart $facilityCart,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->booking->latest()->with(['bookingFacilityDetails.facility', 'user'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->booking->latest()->with(['bookingFacilityDetails.facility', 'user'])->paginate(5);
  }

  public function findById(BookingFacility $booking): BookingFacility
  {
    return $this->booking->where('id', $booking->id)->with(['bookingFacilityDetails.facility', 'user'])->first();
  }

  public function store($request): BookingFacility|Exception
  {
    DB::beginTransaction();
    try {
      $request["code"] = strtoupper(Str::random(10));
      
      $facility_carts = $this->facilityCart->with("facility")->where("user_id", auth()->id())->get();
      $request["user_id"] = auth()->id();

      $booking = $this->booking->create($request);
      $request["details"]["booking_id"] = $booking->id;

      foreach($facility_carts as $cart) {
        $this->bookingDetail->create([
          "booking_facility_id" => $booking->id,
          "facility_id" => $cart->facility_id,
          "qty" => $cart->qty,
          "booking_date" => $cart->booking_date,
          "return_date" => $cart->return_date,
          "rental_price" => $cart->facility->rental_price,
        ]);
      }

      foreach($facility_carts as $cart) {
        $cart->delete();
      }
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $booking;
  }

  public function update($request, BookingFacility $booking): bool
  {
    DB::beginTransaction();    
    try {        
      $update = $booking->updateOrFail($request);			      
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $update;
  }

  public function delete(BookingFacility $booking): bool
  {
    DB::beginTransaction();
    try {
      $delete = $booking->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}