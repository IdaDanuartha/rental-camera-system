<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\DeviceBrand;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookingProductRepository
{
  public function __construct(
    protected readonly Booking $booking,
    protected readonly BookingDetail $bookingDetail,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->booking->latest()->with(['bookingDetails.product', 'user'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->booking->latest()->with(['bookingDetails.product', 'user'])->paginate(10);
  }

  public function findById(Booking $booking): Booking
  {
    return $this->booking->where('id', $booking->id)->with(['bookingDetails.product', 'user'])->first();
  }

  public function store($request): Booking|Exception
  {
    DB::beginTransaction();
    try {
      $booking = $this->booking->create(Arr::except($request, "details"));     
     
      foreach($request["details"] as $detail) {
        $this->bookingDetail->create([
            "booking_id" => $booking->id,
            "product_id" => $detail["product_id"],
            "quantity" => $detail["quantity"],
            "rental_price" => $detail["rental_price"],
            "booking_date" => $detail["booking_date"],
            "rental_date" => $detail["rental_date"],
        ]);
      }
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $booking;
  }

  public function update($request, Booking $booking): bool
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

  public function delete(Booking $booking): bool
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