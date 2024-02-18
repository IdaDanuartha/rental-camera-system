<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Repositories\BookingProductRepository;
use App\Utils\ResponseMessage;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected readonly BookingProductRepository $bookingProduct,
        protected readonly ResponseMessage $responseMessage,
    ) {}

    public function index(Request $request)
    {                                   
        $orders = $this->bookingProduct->findAllPaginate();
        return view("dashboard.orders.index", compact("orders"));
    }

    public function show(Booking $order)
    {                   
        $order = $this->bookingProduct->findById($order);                                
        return view("dashboard.orders.detail", compact("order"));
    }

    public function destroy(Booking $order)
    {
        try {
            $this->bookingProduct->delete($order);

            return redirect()->route('orders.index')->with('success', $this->responseMessage->response('Order', true, 'delete'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', $this->responseMessage->response('order', false, 'delete'));
        }
    }
}
