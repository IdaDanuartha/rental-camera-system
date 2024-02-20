<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\BookingProduct\StoreBookingProduct;
use App\Models\Booking;
use App\Repositories\BookingProductRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductCartRepository;
use App\Repositories\ProductRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class BookingCameraController extends Controller
{
    public function __construct(
        protected readonly ProductRepository $product,
        protected readonly ProductCartRepository $productCart,
        protected readonly BookingProductRepository $bookingProduct,
        protected readonly CustomerRepository $customer,
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

    public function create()
    {
        $products = $this->product->findAll();
        $product_carts = $this->productCart->findAll();
        $customers = $this->customer->findAll();

        return view("dashboard.bookings.camera.create", compact("products", "product_carts", "customers"));
    }

    public function edit(Booking $camera)
    {
        return view("dashboard.bookings.camera.edit", compact("camera"));
    }

    public function show(Booking $camera)
    {
        return view("dashboard.bookings.camera.detail", compact("camera"));
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

    public function update(StoreBookingProduct $request, Booking $camera)
    {
        try {
            $update = $this->bookingProduct->update($request->validated(), $camera);

            if($update instanceof Booking) return redirect(route("bookings.cameras.index"))
                                ->with("success", "Transaction updated successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.cameras.index"))->with("error", "Failed to updated transaction");
        }
    }

    public function destroy(Booking $camera)
    {
        try {
            $delete = $this->bookingProduct->delete($camera);

            if($delete instanceof Booking) return redirect(route("bookings.cameras.index"))
                                ->with("success", "Transaction deleted successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.cameras.index"))->with("error", "Failed to deleted transaction");
        }
    }
}
