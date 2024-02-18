<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\DeviceBrand;
use App\Models\ProductCart;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingProductRepository
{
  public function __construct(
    protected readonly Booking $booking,
    protected readonly BookingDetail $bookingDetail,
    protected readonly ProductCart $productCart,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->booking->latest()->with(['bookingDetails.product', 'user'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->booking->latest()->with(['bookingDetails.product', 'user'])->paginate(5);
  }

  public function findById(Booking $booking): Booking
  {
    return $this->booking->where('id', $booking->id)->with(['bookingDetails.product', 'user'])->first();
  }

  public function store($request): Booking|Exception
  {
    DB::beginTransaction();
    try {
      $request["code"] = strtoupper(Str::random(10));
      
      $product_carts = $this->productCart->with("product")->where("user_id", auth()->id())->get();
      $request["user_id"] = auth()->id();

      $booking = $this->booking->create($request);
      $request["details"]["booking_id"] = $booking->id;

      foreach($product_carts as $cart) {
        $this->bookingDetail->create([
          "booking_id" => $booking->id,
          "product_id" => $cart->product_id,
          "qty" => $cart->qty,
          "booking_date" => $cart->booking_date,
          "return_date" => $cart->return_date,
          "rental_price" => $cart->product->rental_price,
        ]);
      }

      foreach($product_carts as $cart) {
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