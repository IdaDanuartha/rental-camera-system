<?php

namespace App\Http\Controllers;

use App\Models\ProductCart;
use App\Repositories\ProductCartRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class ProductCartController extends Controller
{
    public function __construct(
        protected readonly ProductCartRepository $productCart,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $product_carts = $this->productCart->findAll();

        return response()->json([
            "product_carts" => $product_carts
        ]);
    }

    public function show(ProductCart $product)
    {                                                   
        return response()->json([
            "product_cart" => $this->productCart->findById($product),
        ]);
    }

    public function store(Request $request)
    {        
        try {
            $store = $this->productCart->store($request->product_id);

            if($store instanceof ProductCart) {
                return response()->json([
                    "data" => $store,
                    "code" => 201,
                    "message" => "Product has been added from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return response()->json([
                "code" => 400,
                "message" => "Failed to add product to cart"
            ]);
        }
    }

    public function incrementQty(Request $request, ProductCart $product)
    {
        try {                     
            $update = $this->productCart->incrementQty($product);

            if($update) {
                return response()->json([
                    "code" => 200,
                    "message" => "Product has been updated from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                "code" => 400,
                "message" => "Failed to update product to cart"
            ]);
        }
    }

    public function decrementQty(Request $request, ProductCart $product)
    {
        try {                     
            $update = $this->productCart->decrementQty($product);

            if($update) {
                return response()->json([
                    "code" => 200,
                    "message" => "Product has been updated from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                "code" => 400,
                "message" => "Failed to update product to cart"
            ]);
        }
    }

    public function destroy(ProductCart $product)
    {
        try {
            $delete = $this->productCart->delete($product);

            if($delete) {
                return response()->json([
                    "code" => 200,
                    "message" => "Product has been deleted from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {    
            logger($e->getMessage());
        
            return response()->json([
                "code" => 400,
                "message" => "Failed to delete product to cart"
            ]);
        }
    }
}
