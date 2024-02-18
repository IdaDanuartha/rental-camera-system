<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCart;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductCartRepository
{
  public function __construct(
    protected readonly ProductCart $productCart,
    protected readonly Product $product,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->productCart->with(["user", "product.productImages"])->where("user_id", auth()->id())->latest()->get();
  }

  public function findById(ProductCart $productCart): ProductCart
  {
    return $this->productCart->where('id', $productCart->id)->with(["user", "product.productImages"])->first();
  }

  public function store($product_id): ProductCart|bool|Exception
  {
    DB::beginTransaction();
    try {        
      $product_cart = $this->productCart->where("product_id", $product_id)->first();

      if(!$product_cart) {
        $productCart = $this->productCart->create([
          "product_id" => $product_id,
          "user_id" => auth()->id()
        ]);

        DB::commit();
        return $productCart;
      } else {
        $product_cart->qty += 1;
        $product_cart->update();

        DB::commit();
        return $product_cart;
      }
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
  }

  public function changeBookingDate($request, ProductCart $productCart): bool
  {
    DB::beginTransaction();    
    try {  
      $update = $productCart->updateOrFail([
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

  // public function incrementQty(ProductCart $productCart): bool
  // {
  //   DB::beginTransaction();    
  //   try {  
  //     $product = $this->product->find($productCart->product_id);

  //     if($productCart->qty < $product->stock) {
  //       $update = $productCart->updateOrFail([
  //         "qty" => ++$productCart->qty
  //       ]);	
  //     } else {
  //       $update = false;
  //     }    
  //   } catch (\Exception $e) {  
  //     logger($e->getMessage());
  //     DB::rollBack();
      
  //     return $e;
  //   }

  //   DB::commit();
  //   return $update;
  // }

  // public function decrementQty(ProductCart $productCart): bool
  // {
  //   DB::beginTransaction();    
  //   try {        
  //     if($productCart->qty > 1) {
  //       $update = $productCart->updateOrFail([
  //         "qty" => --$productCart->qty
  //       ]);	
  //     } else {
  //       $update = false;
  //     }		      
  //   } catch (\Exception $e) {  
  //     logger($e->getMessage());
  //     DB::rollBack();
      
  //     return $e;
  //   }

  //   DB::commit();
  //   return $update;
  // }

  public function delete(ProductCart $productCart): bool
  {
    DB::beginTransaction();
    try {
      $delete = $productCart->deleteOrFail();      
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete;
  }
}