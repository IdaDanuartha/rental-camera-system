<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceType\StoreDeviceTypeRequest;
use App\Http\Requests\DeviceType\UpdateDeviceTypeRequest;
use App\Models\DeviceType;
use App\Repositories\DeviceTypeRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class DeviceTypeController extends Controller
{
    public function __construct(
        protected readonly DeviceTypeRepository $deviceType,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $device_types = $this->deviceType->findAllPaginate();
        return view('dashboard.devices.types', compact('device_types'));
    }

    public function show(DeviceType $type)
    {                                                   
        return response()->json([
            "device_type" => $this->deviceType->findById($type)
        ]);
    }

    public function store(StoreDeviceTypeRequest $request)
    {        
        try {
            $store = $this->deviceType->store($request->validated());

            if($store) return redirect(route("devices.types.index"))
                                ->with("success", $this->responseMessage->response('Device type'));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("devices.types.create"))->with("failed", $this->responseMessage->response('device type', false));
        }
    }

    public function update(UpdateDeviceTypeRequest $request, DeviceType $type)
    {
        try {                     
            $update = $this->deviceType->update($request->validated(), $type);

            if($update) return redirect(route('devices.types.index'))
                                ->with('success', $this->responseMessage->response('Device type', true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('devices.types.edit', $type->id)->with('error', $this->responseMessage->response('device type', false, 'update'));
        }
    }

    public function destroy(DeviceType $type)
    {
        try {
            $this->deviceType->delete($type);

            return redirect()->route('devices.types.index')->with('success', $this->responseMessage->response('Device type', true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('devices.types.index')->with('error', $this->responseMessage->response('device type', false, 'delete'));
        }
    }
}
