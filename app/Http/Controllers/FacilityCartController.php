<?php

namespace App\Http\Controllers;

use App\Models\FacilityCart;
use App\Repositories\FacilityCartRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class FacilityCartController extends Controller
{
    public function __construct(
        protected readonly FacilityCartRepository $facilityCart,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $facility_carts = $this->facilityCart->findAll();

        return response()->json([
            "facility_carts" => $facility_carts
        ]);
    }

    public function show(FacilityCart $facility)
    {                                                   
        return response()->json([
            "facility_cart" => $this->facilityCart->findById($facility),
        ]);
    }

    public function store(Request $request)
    {        
        try {
            $store = $this->facilityCart->store($request->facility_id);

            if($store instanceof FacilityCart) {
                return response()->json([
                    "data" => $store,
                    "code" => 201,
                    "message" => "Facility has been added from cart"
                ]);
            }
            throw new Exception();
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return response()->json([
                "code" => 500,
                "message" => "Failed to add facility to cart"
            ]);
        }
    }

    public function changeBookingDate(Request $request, FacilityCart $facility)
    {
        try {                     
            $update = $this->facilityCart->changeBookingDate($request->all(), $facility);

            if($update) {
                return response()->json([
                    "code" => 200,
                    "message" => "Facility has been updated from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                "code" => 500,
                "message" => "Failed to update facility to cart"
            ]);
        }
    }

    public function destroy(FacilityCart $facility)
    {
        try {
            $delete = $this->facilityCart->delete($facility);

            if($delete) {
                return response()->json([
                    "code" => 200,
                    "message" => "Facility has been deleted from cart"
                ]);
            }
            throw new Exception;
        } catch (\Exception $e) {    
            logger($e->getMessage());
        
            return response()->json([
                "code" => 500,
                "message" => "Failed to delete facility to cart"
            ]);
        }
    }
}
