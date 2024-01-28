<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Models\Staff;
use App\Repositories\StaffRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct(
        protected readonly StaffRepository $staff,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $staff = $this->staff->findAllPaginate();
        return view('dashboard.staff.index', compact('staff'));
    }

    public function create()
    {                                           
        return view('dashboard.staff.create');
    }

    public function show(Staff $staff)
    {                                                   
        return view('dashboard.staff.detail', compact('staff'));
    }

    public function edit(Staff $staff)
    {                                           
        return view('dashboard.staff.edit', compact('staff'));
    }

    public function store(StoreStaffRequest $request)
    {        
        try {
            $store = $this->staff->store($request->validated());

            if($store) return redirect(route("staff.index"))
                                ->with("success", $this->responseMessage->response('Staff'));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("staff.create"))->with("failed", $this->responseMessage->response('staff', false));
        }
    }

    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        try {                     
            $update = $this->staff->update($request->validated(), $staff);

            if($update) return redirect(route('staff.index'))
                                ->with('success', $this->responseMessage->response('Staff', true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('staff.edit', $staff->id)->with('error', $this->responseMessage->response('staff', false, 'update'));
        }
    }

    public function destroy(Staff $staff)
    {
        try {
            $this->staff->delete($staff);

            return redirect()->route('staff.index')->with('success', $this->responseMessage->response('Staff', true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('staff.index')->with('error', $this->responseMessage->response('staff', false, 'delete'));
        }
    }
}
