<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Product;
use App\Utils\UploadFile;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
  public function __construct(
    protected readonly Product $product,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->product->latest()->with(['deviceSeries.deviceBrand'])->get();
  }

  public function findAllPaginate(): LengthAwarePaginator
  {
    return $this->product->latest()->with(['deviceSeries.deviceBrand'])->paginate(10);
  }

  public function findById(Product $product): Product
  {
    return $this->product->where('id', $product->id)->with(['deviceSeries.deviceBrand'])->first();
  }

  public function store($request): Product|Exception
  {
    DB::beginTransaction();
    try {  
      $product = $this->product->create($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }
    DB::commit();
    return $product;
  }

  public function update($request, Product $product): bool
  {
    DB::beginTransaction();    
    try {  
      $product->updateOrFail($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return true;
  }

  public function delete(Product $product): bool
  {
    DB::beginTransaction();
    try {
      $delete_product = $product->deleteOrFail();
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }    

    DB::commit();
    return $delete_product;
  }
}