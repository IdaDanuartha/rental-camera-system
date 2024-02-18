<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingFacility;
use App\Repositories\BookingFacilityRepository;
use App\Repositories\BookingProductRepository;
use App\Utils\ResponseMessage;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected readonly BookingProductRepository $bookingProduct,
        protected readonly BookingFacilityRepository $bookingFacility,
        protected readonly ResponseMessage $responseMessage,
    ) {}

    public function index(Request $request)
    {                                   
        $camera_orders = $this->bookingProduct->findAllPaginate();
        $facility_orders = $this->bookingFacility->findAllPaginate();

        return view("dashboard.orders.index", compact("camera_orders", "facility_orders"));
    }

    public function showCamera(Booking $order)
    {                   
        $order = $this->bookingProduct->findById($order);                                
        return view("dashboard.orders.detail", compact("order"));
    }

    public function showFacility(BookingFacility $order)
    {                   
        $order = $this->bookingFacility->findById($order);                                
        return view("dashboard.orders.detail", compact("order"));
    }

    public function destroyCamera(Booking $order)
    {
        try {
            $this->bookingProduct->delete($order);

            return redirect()->route('orders.index')->with('success', $this->responseMessage->response('Order', true, 'delete'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', $this->responseMessage->response('order', false, 'delete'));
        }
    }

    public function destroyFacility(BookingFacility $order)
    {
        try {
            $this->bookingFacility->delete($order);

            return redirect()->route('orders.index')->with('success', $this->responseMessage->response('Order', true, 'delete'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', $this->responseMessage->response('order', false, 'delete'));
        }
    }
}
