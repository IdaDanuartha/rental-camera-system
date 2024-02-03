<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityType\StoreFacilityTypeRequest;
use App\Http\Requests\FacilityType\UpdateFacilityTypeRequest;
use App\Models\FacilityType;
use App\Repositories\FacilityTypeRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class FacilityTypeController extends Controller
{
    public function __construct(
        protected readonly FacilityTypeRepository $deviceType,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $facility_types = $this->deviceType->findAllPaginate();
        return view('dashboard.facility-types.index', compact('facility_types'));
    }

    public function show(FacilityType $type)
    {                                                   
        return response()->json([
            "facility_type" => $this->deviceType->findById($type)
        ]);
    }

    public function store(StoreFacilityTypeRequest $request)
    {        
        try {
            $store = $this->deviceType->store($request->validated());

            if($store) return redirect(route("facilities.types.index"))
                                ->with("success", $this->responseMessage->response('Facility type'));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("facilities.types.index"))->with("error", $this->responseMessage->response('facility type', false));
        }
    }

    public function update(UpdateFacilityTypeRequest $request, FacilityType $type)
    {
        try {                     
            $update = $this->deviceType->update($request->validated(), $type);

            if($update) return redirect(route('facilities.types.index'))
                                ->with('success', $this->responseMessage->response('Facility type', true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('facilities.types.index', $type->id)->with('error', $this->responseMessage->response('facility type', false, 'update'));
        }
    }

    public function destroy(FacilityType $type)
    {
        try {
            $this->deviceType->delete($type);

            return redirect()->route('facilities.types.index')->with('success', $this->responseMessage->response('Facility type', true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('facilities.types.index')->with('error', $this->responseMessage->response('facility type', false, 'delete'));
        }
    }
}
