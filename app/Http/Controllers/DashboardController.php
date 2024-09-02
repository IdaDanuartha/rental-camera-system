<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Booking;
use App\Models\BookingFacility;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly Staff $staff,
        protected readonly Customer $customer,
        protected readonly Booking $bookingProduct,
        protected readonly BookingFacility $bookingFacility,
    ) {}
    public function __invoke()
    {
        // Get Data This Year
        $bookingData = Booking::select(DB::raw("SUM(total_price) as total_price"))
                            ->whereYear("created_at", date('Y'))
                            ->groupBy(DB::raw("Month(created_at)"))
                            ->pluck("total_price");

        $bookingFacilityData = BookingFacility::select(DB::raw("SUM(total_price) as total_price"))
                            ->whereYear("created_at", date('Y'))
                            ->groupBy(DB::raw("Month(created_at)"))
                            ->pluck("total_price");

        $months = Booking::select(DB::raw("Month(created_at) as month"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck("month");

        $income_yearly = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $booking = count($bookingData) ? $bookingData[$index] : 0;
            $facility = count($bookingFacilityData) ? $bookingFacilityData[$index] : 0;

            $income_yearly[$month - 1] = $booking + $facility;
        }

        $staff_count = 0;
        $customer_count = 0;
        $transaction_rented = 0;
        $transaction_returned = 0;
        $camera_rented = 0;
        $camera_returned = 0;
        $facility_rented = 0;
        $facility_returned = 0;

        if(auth()->user()->role === Role::CUSTOMER) {
            $camera_rented = $this->bookingProduct->where("user_id", auth()->id())->where("status", 1)->count();
            $camera_returned = $this->bookingProduct->where("user_id", auth()->id())->where("status", 2)->count();
            $facility_rented = $this->bookingFacility->where("user_id", auth()->id())->where("status", 1)->count();
            $facility_returned = $this->bookingFacility->where("user_id", auth()->id())->where("status", 2)->count();
        } else {
            $staff_count = $this->staff->count();
            $customer_count = $this->customer->count();
            $transaction_rented = $this->bookingProduct->where("status", 1)->count() + $this->bookingFacility->where("status", 1)->count();
            $transaction_returned = $this->bookingProduct->where("status", 2)->count() + $this->bookingFacility->where("status", 2)->count();
            $camera_rented = $this->bookingProduct->where("status", 1)->count();
            $camera_returned = $this->bookingProduct->where("status", 2)->count();
            $facility_rented = $this->bookingFacility->where("status", 1)->count();
            $facility_returned = $this->bookingFacility->where("status", 2)->count();
        }


        return view('dashboard.analytics.index', compact(
            "staff_count", 
            "customer_count", 
            "transaction_rented", 
            "transaction_returned",
            "camera_rented", 
            "camera_returned",
            "facility_rented", 
            "facility_returned",
            "income_yearly"
        ));
    }
}
