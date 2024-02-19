<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\BookingFacility\StoreBookingFacility;
use App\Models\BookingFacility;
use App\Repositories\BookingFacilityRepository;
use App\Repositories\FacilityRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class BookingFacilityController extends Controller
{
    public function __construct(
        protected readonly FacilityRepository $facility,
        protected readonly BookingFacilityRepository $bookingFacility,
        protected readonly ResponseMessage $responseMessage
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === Role::CUSTOMER) {
            $facilities = $this->facility->findAllPaginate(12);
            return view("dashboard.bookings.book-facility", compact("facilities"));
        }
        else {
            $transactions = $this->bookingFacility->findAllPaginate(10);
            return view("dashboard.bookings.facility.index", compact("transactions"));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingFacility $request)
    {
        try {
            $store = $this->bookingFacility->store($request->validated());

            if($store instanceof BookingFacility) return redirect(route("bookings.facilities.index"))
                                ->with("success", "Facility booked successfully");
            throw new Exception();
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.facilities.index"))->with("error", "Failed to booked facility");
        }
    }
}
