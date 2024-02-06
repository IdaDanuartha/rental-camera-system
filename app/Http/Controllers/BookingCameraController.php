<?php

namespace App\Http\Controllers;

use App\Repositories\BookingProductRepository;
use App\Repositories\ProductRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class BookingCameraController extends Controller
{
    public function __construct(
        protected readonly ProductRepository $product,
        protected readonly BookingProductRepository $bookingProduct,
        protected readonly ResponseMessage $responseMessage
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->findAllPaginate(12);
        return view("dashboard.bookings.book-camera", compact("products"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $store = $this->bookingProduct->store($request->validated());

            if($store) return redirect(route("customers.index"))
                                ->with("success", "Camera booked successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("customers.create"))->with("error", "Failed to booked camera");
        }
    }
}
