<?php

namespace App\Http\Controllers;

use App\Http\Requests\Facility\StoreFacilityRequest;
use App\Http\Requests\Facility\UpdateFacilityRequest;
use App\Models\Facility;
use App\Repositories\FacilityRepository;
use App\Repositories\FacilityTypeRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function __construct(
        protected readonly FacilityRepository $facility,
        protected readonly FacilityTypeRepository $facility_type,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $facilities = $this->facility->findAllPaginate();
        return view('dashboard.facilities.index', compact("facilities"));
    }

    public function create()
    {                          
        $facility_types = $this->facility_type->findAll();
                 
        return view('dashboard.facilities.create', compact("facility_types"));
    }

    public function show(Facility $index)
    {                              
        $facility = $index;      
        return view('dashboard.facilities.detail', compact("facility"));
    }

    public function edit(Facility $index)
    {         
        $facility_types = $this->facility_type->findAll();
        $facility = $index;      
                    
        return view('dashboard.facilities.edit', compact("facility", "facility_types"));
    }

    public function store(StoreFacilityRequest $request)
    {        
        try {
            $store = $this->facility->store($request->validated());

            if($store) return redirect(route("facilities.index.index"))
                                ->with("success", $this->responseMessage->response("Facility"));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("facilities.index.create"))->with("error", $this->responseMessage->response("facility", false));
        }
    }

    public function update(UpdateFacilityRequest $request, Facility $index)
    {
        try {                     
            $update = $this->facility->update($request->validated(), $index);

            if($update) return redirect(route('facilities.index.index'))
                                ->with('success', $this->responseMessage->response("Facility", true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('facilities.index.edit', $index->id)->with('error', $this->responseMessage->response("facility", false, 'update'));
        }
    }

    public function destroy(Facility $index)
    {
        try {
            $this->facility->delete($index);

            return redirect()->route('facilities.index.index')->with('success', $this->responseMessage->response("Facility", true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('facilities.index.index')->with('error', $this->responseMessage->response("facility", false, 'delete'));
        }
    }
}
