<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\DeviceSeriesRepository;
use App\Repositories\ProductRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductRepository $product,
        protected readonly DeviceSeriesRepository $device_series,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $products = $this->product->findAllPaginate();
        return view('dashboard.products.index', compact("products"));
    }

    public function create()
    {                          
        $device_series = $this->device_series->findAll();
                 
        return view('dashboard.products.create', compact("device_series"));
    }

    public function show(Product $product)
    {                                    
        return view('dashboard.products.detail', compact("product"));
    }

    public function showJson(Product $product)
    {                                    
        return response()->json([
            "product" => $this->product->findById($product)
        ]);
    }

    public function edit(Product $product)
    {         
        $device_series = $this->device_series->findAll();
                                  
        return view('dashboard.products.edit', compact("product", "device_series"));
    }

    public function store(StoreProductRequest $request)
    {        
        try {
            $store = $this->product->store($request->validated());

            if($store instanceof Product) return redirect(route("products.index"))
                                ->with("success", $this->responseMessage->response("Product"));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("products.create"))->with("error", $this->responseMessage->response("product", false));
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {                     
            $update = $this->product->update($request->validated(), $product);

            if($update) return redirect(route('products.index'))
                                ->with('success', $this->responseMessage->response("Product", true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('products.edit', $product->id)->with('error', $this->responseMessage->response("product", false, 'update'));
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->product->delete($product);

            return redirect()->route('products.index')->with('success', $this->responseMessage->response("Product", true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('products.index')->with('error', $this->responseMessage->response("product", false, 'delete'));
        }
    }
}
