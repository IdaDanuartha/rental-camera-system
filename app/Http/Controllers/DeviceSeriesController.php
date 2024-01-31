<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceSeries\StoreDeviceSeriesRequest;
use App\Http\Requests\DeviceSeries\UpdateDeviceSeriesRequest;
use App\Models\DeviceSeries;
use App\Repositories\DeviceBrandRepository;
use App\Repositories\DeviceSeriesRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class DeviceSeriesController extends Controller
{
    public function __construct(
        protected readonly DeviceSeriesRepository $deviceSeries,
        protected readonly DeviceBrandRepository $deviceBrand,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $device_series = $this->deviceSeries->findAllPaginate();
        $device_brands = $this->deviceBrand->findAll();

        return view('dashboard.devices.series', compact('device_series', 'device_brands'));
    }

    public function show(DeviceSeries $series)
    {                                                   
        return response()->json([
            "device_series" => $this->deviceSeries->findById($series),
            "device_brands" => $this->deviceBrand->findAll()
        ]);
    }

    public function store(StoreDeviceSeriesRequest $request)
    {        
        try {
            $store = $this->deviceSeries->store($request->validated());

            if($store) return redirect(route("devices.series.index"))
                                ->with("success", $this->responseMessage->response('Device series'));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("devices.types.create"))->with("failed", $this->responseMessage->response('device series', false));
        }
    }

    public function update(UpdateDeviceSeriesRequest $request, DeviceSeries $series)
    {
        try {                     
            $update = $this->deviceSeries->update($request->validated(), $series);

            if($update) return redirect(route('devices.series.index'))
                                ->with('success', $this->responseMessage->response('Device series', true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('devices.types.edit', $series->id)->with('error', $this->responseMessage->response('device series', false, 'update'));
        }
    }

    public function destroy(DeviceSeries $series)
    {
        try {
            $this->deviceSeries->delete($series);

            return redirect()->route('devices.series.index')->with('success', $this->responseMessage->response('Device series', true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('devices.series.index')->with('error', $this->responseMessage->response('device series', false, 'delete'));
        }
    }
}
