<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Product;
use App\Models\ProductImage;
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
    protected readonly ProductImage $productImage,
    protected readonly UploadFile $uploadFile
  ) {}

  public function findAll(): Collection
  {
    return $this->product->latest()->with(['deviceSeries.deviceBrand', 'productImages'])->get();
  }

  public function findAllPaginate($paginate = 10): LengthAwarePaginator
  {
    return $this->product->latest()->with(['deviceSeries.deviceBrand', 'productImages'])->paginate($paginate);
  }

  public function findById(Product $product): Product
  {
    return $this->product->where('id', $product->id)->with(['deviceSeries.deviceBrand', 'productImages'])->first();
  }

  public function findImageDeleted($product_id, $image_deleted): Collection
  {
    return $this->productImage->where('product_id', $product_id)->whereIn("id", explode(",", $image_deleted["image_deleted"]))->get(); 
  }

  public function store($request): Product|Exception
  {
    DB::beginTransaction();
    try {   
      $product = $this->product->create(Arr::except($request, "images"));
      
      foreach($request["images"] as $image) {
        $filename = $this->uploadFile->uploadSingleFile($image, "products");
        $this->productImage->create([
          "product_id" => $product->id,
          "image" => $filename
        ]);
      }

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
      if(Arr::get($request, "image_deleted")) {
        foreach($this->findImageDeleted($product->id, Arr::only($request, "image_deleted")) as $image) {                      
          $this->uploadFile->deleteExistFile("products/$image->image");        
          $image->delete();
        } 
      }
      
      foreach($request["images"] as $image) {
        $filename = $this->uploadFile->uploadSingleFile($image, "products");
        $this->productImage->create([
          'product_id' => $product->id,
          'image' => $filename
        ]);
      }

      $product_updated = $product->updateOrFail($request);
    } catch (\Exception $e) {  
      logger($e->getMessage());
      DB::rollBack();
      
      return $e;
    }

    DB::commit();
    return $product_updated;
  }

  public function delete(Product $product): bool
  {
    DB::beginTransaction();
    try {
      foreach($product->productImages as $image) {                              
        $this->uploadFile->deleteExistFile("products/$image->image");
        $image->delete();
      } 

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