@extends('layouts.main')
@section('title', 'Detail Transaction Page')

@section('main')
<form class="row">
  <div class="col-lg-8 col-12 mb-lg-0 mb-3">
    <div class="card">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-header">Detail Transaction</h5>    
      </div>  
      <div class="mx-4 mb-4">
        <div class="row">
          <div class="col-span-12 md:col-span-8 flex mt-2 flex-col">
            <div class="flex items-center mb-2">
              <label for="" class="text-second">Items</label>
            </div>
          </div>
          <div class="col-span-12 md:col-span-8 flex mt-2 mb-4 flex-col" id="facility_carts">
            @foreach ($facility->bookingFacilityDetails as $item)
              <div class="facility-cart">
                <input type="hidden" class="facility_cart_id" value="${cart.id}" />
                <div class="d-flex align-items-center">
                    <img src="/uploads/facilities/{{ $item->facility->facilityImages[0]->image }}" class="rounded me-2" width="250" alt="">
                    <div class="ms-3 flex flex-col">
                        <h5 class="">{{ $item->facility->name }}</h5>
                        <div class="d-flex align-items-center">
                            <p>Rp @rupiah($item->rental_price)</p>
                            <p class="mx-2">x</p>
                            <p>{{ $item->qty }} day</p>
                        </div>
                        <label for="">Booking Date</label>
                      <div class="d-flex">
                          <div class="me-2 mt-2" style="width:100%;">
                              <input type="text" class="form-control start-book-input me-2" value="{{ $item->booking_date->format("d M Y") . " s/d " . $item->return_date->format("d M Y") }}" />
                          </div>
                      </div>
                    </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>  
      </div> 
    </div> 
  </div>
  <div class="col-lg-4 col-12">
    <div class="card">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-header">Details</h5>    
      </div>  
      <div class="mx-4 mb-4">
        <div class="row">
          <div class="col-12 mb-3">
            <label for="user_id" class="form-label">Customer</label>
          <input
            type="text"
            class="form-control"
            readonly
            value="{{ $facility->user->authenticatable->name }}"
            readonly />
          </div>
          <div class="col-12 mb-3">
            <label for="total_payment" class="form-label">Pay</label>
            <input
              type="text"
              class="form-control"
              value="Rp @rupiah($facility->total_payment)" 
              readonly />
          </div>
          <div class="col-12 mb-3">
            <label for="" class="form-label">Total</label>
            <input type="hidden" name="total_price" id="total-price">
            <input
              type="text"
              class="form-control"
              value="Rp @rupiah($facility->total_price)" 
              readonly />
          </div>
          <div class="col-12 mb-3">
            <label for="total-return" class="form-label">Return</label>
              <input
              type="text"
              class="form-control"
              value="Rp @rupiah($facility->total_return)" 
              readonly />
          </div>
          <div class="col-12 mb-3">
            <label for="total-return" class="form-label">Status</label>
              <input
              type="text"
              class="form-control"
              value="{{ $facility->status == 1 ? "Rented" : "Returned" }}" 
              readonly />
          </div>
          <div class="col-span-12 flex items-center gap-3 mt-2">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary" type="reset">Back</a>
          </div>
        </div>  
      </div> 
    </div> 
</div>
</form>
@endsection