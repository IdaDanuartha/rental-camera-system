<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceBrand\StoreDeviceBrandRequest;
use App\Http\Requests\DeviceBrand\UpdateDeviceBrandRequest;
use App\Models\DeviceBrand;
use App\Repositories\DeviceBrandRepository;
use App\Repositories\DeviceTypeRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class DeviceBrandController extends Controller
{
    public function __construct(
        protected readonly DeviceBrandRepository $deviceBrand,
        protected readonly DeviceTypeRepository $deviceType,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $device_brands = $this->deviceBrand->findAllPaginate();
        $device_types = $this->deviceType->findAll();

        return view('dashboard.devices.brands', compact('device_brands', 'device_types'));
    }

    public function show(DeviceBrand $brand)
    {                                                   
        return response()->json([
            "device_brand" => $this->deviceBrand->findById($brand),
            "device_types" => $this->deviceType->findAll()
        ]);
    }

    public function store(StoreDeviceBrandRequest $request)
    {        
        try {
            $store = $this->deviceBrand->store($request->validated());

            if($store) return redirect(route("devices.brands.index"))
                                ->with("success", $this->responseMessage->response('Device brand'));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("devices.types.create"))->with("failed", $this->responseMessage->response('device brand', false));
        }
    }

    public function update(UpdateDeviceBrandRequest $request, DeviceBrand $brand)
    {
        try {                     
            $update = $this->deviceBrand->update($request->validated(), $brand);

            if($update) return redirect(route('devices.brands.index'))
                                ->with('success', $this->responseMessage->response('Device brand', true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('devices.types.edit', $brand->id)->with('error', $this->responseMessage->response('device brand', false, 'update'));
        }
    }

    public function destroy(DeviceBrand $brand)
    {
        try {
            $this->deviceBrand->delete($brand);

            return redirect()->route('devices.brands.index')->with('success', $this->responseMessage->response('Device brand', true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('devices.brands.index')->with('error', $this->responseMessage->response('device brand', false, 'delete'));
        }
    }
}
