<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\BookingProduct\StoreBookingProduct;
use App\Models\Booking;
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
        if(auth()->user()->role === Role::CUSTOMER) {
            $products = $this->product->findAllPaginate(12);
            return view("dashboard.bookings.book-camera", compact("products"));
        }
        else {
            $transactions = $this->bookingProduct->findAllPaginate(10);
            return view("dashboard.bookings.camera.index", compact("transactions"));
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingProduct $request)
    {
        try {
            $store = $this->bookingProduct->store($request->validated());

            if($store instanceof Booking) return redirect(route("bookings.cameras.index"))
                                ->with("success", "Camera booked successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.cameras.index"))->with("error", "Failed to booked camera");
        }
    }
}
