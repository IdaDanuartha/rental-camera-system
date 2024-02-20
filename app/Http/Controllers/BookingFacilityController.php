<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\BookingFacility\StoreBookingFacility;
use App\Http\Requests\BookingFacility\UpdateBookingFacility;
use App\Models\BookingFacility;
use App\Repositories\BookingFacilityRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\FacilityCartRepository;
use App\Repositories\FacilityRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class BookingFacilityController extends Controller
{
    public function __construct(
        protected readonly FacilityRepository $facility,
        protected readonly BookingFacilityRepository $bookingFacility,
        protected readonly FacilityCartRepository $facilityCart,
        protected readonly CustomerRepository $customer,
        protected readonly ResponseMessage $responseMessage
    ) {}

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

    public function create()
    {
        $facilities = $this->facility->findAll();
        $facility_carts = $this->facilityCart->findAll();
        $customers = $this->customer->findAll();

        return view("dashboard.bookings.facility.create", compact("facilities", "facility_carts", "customers"));
    }

    public function edit(BookingFacility $facility)
    {
        return response()->json([
            "facility" => $facility
        ]);
    }

    public function show(BookingFacility $facility)
    {
        return view("dashboard.bookings.facility.detail", compact("facility"));
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
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.facilities.index"))->with("error", "Failed to booked facility");
        }
    }

    public function update(UpdateBookingFacility $request, BookingFacility $facility)
    {
        try {
            $update = $this->bookingFacility->update($request->validated(), $facility);

            if($update == true) return redirect(route("bookings.facilities.index"))
                                ->with("success", "Transaction updated successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.facilities.index"))->with("error", "Failed to updated transaction");
        }
    }

    public function destroy(BookingFacility $facility)
    {
        try {
            $delete = $this->bookingFacility->delete($facility);

            if($delete == true) return redirect(route("bookings.facilities.index"))
                                ->with("success", "Transaction deleted successfully");
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("bookings.facilities.index"))->with("error", "Failed to deleted transaction");
        }
    }
}
