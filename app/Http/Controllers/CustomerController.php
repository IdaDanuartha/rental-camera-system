<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Utils\ResponseMessage;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        protected readonly CustomerRepository $customer,
        protected readonly ResponseMessage $responseMessage
    ) {}

    public function index(Request $request)
    {                                   
        $customers = $this->customer->findAllPaginate();
        return view('dashboard.customers.index', compact("customers"));
    }

    public function create()
    {                                           
        return view('dashboard.customers.create');
    }

    public function show(Customer $customer)
    {                                                   
        return view('dashboard.customers.detail', compact("customer"));
    }

    public function edit(Customer $customer)
    {                                           
        return view('dashboard.customers.edit', compact("customer"));
    }

    public function store(StoreCustomerRequest $request)
    {        
        try {
            $store = $this->customer->store($request->validated());

            if($store) return redirect(route("customers.index"))
                                ->with("success", $this->responseMessage->response("Customer"));
            throw new Exception;
        } catch (\Exception $e) {  
            logger($e->getMessage());

            return redirect(route("customers.create"))->with("failed", $this->responseMessage->response("customer", false));
        }
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {                     
            $update = $this->customer->update($request->validated(), $customer);

            if($update) return redirect(route('customers.index'))
                                ->with('success', $this->responseMessage->response("Customer", true, 'update'));
            throw new Exception;
        } catch (\Exception $e) {
            return redirect()->route('customers.edit', $customer->id)->with('error', $this->responseMessage->response("customer", false, 'update'));
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $this->customer->delete($customer);

            return redirect()->route('customers.index')->with('success', $this->responseMessage->response("Customer", true, 'delete'));
        } catch (\Exception $e) {            
            return redirect()->route('customers.index')->with('error', $this->responseMessage->response("customer", false, 'delete'));
        }
    }
}
