@extends('layouts.main')
@section('title', 'Add Transaction Page')

@section('main')
<form class="row" action="{{ route('bookings.facilities.store') }}" method="post">
  @csrf
  <div class="col-lg-8 col-12 mb-lg-0 mb-3">
    <div class="card">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-header">Create New Transaction</h5>    
      </div>  
      <div class="mx-4 mb-4">
        <div class="row">
          <div class="col-span-12 md:col-span-8 flex mt-2 flex-col">
            <div class="flex items-center mb-2">
              <label for="" class="text-second">Add Item</label>
              <button data-bs-toggle="modal"
              data-bs-target="#showFacilityModal" type="button" class="p-1 btn">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="col-span-12 md:col-span-8 flex mt-2 mb-4 flex-col" id="facility_carts">
            
          </div>
          {{-- <div class="col-span-12 flex items-center gap-3 mt-2">
            <a href="{{ route('bookings.facilities.index') }}" class="btn btn-secondary" type="reset">Cancel Add</a>
          </div> --}}
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
            <select required class="customer-select2 form-control" name="user_id">
              <option value="">Select Customer</option>
              @foreach ($customers as $item)
                @if (old('user_id') === $item->user->id)
                  <option value="{{ $item->user->id }}" selected>{{ $item->name }}</option>
                @else
                  <option value="{{ $item->user->id }}">{{ $item->name }}</option>  
                @endif
              @endforeach
            </select>
            @error('user_id')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 mb-3">
            <label for="total_payment" class="form-label">Pay</label>
            <input
              type="text"
              id="total_payment"
              name="total_payment"
              class="form-control total-pay-input"
              value="{{ old('total_payment') }}"
              required
              placeholder="Enter total payment" />
            @error('total_payment')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 mb-3">
            <label for="" class="form-label">Total</label>
            <input type="hidden" name="total_price" id="total-price">
            <div
              id="total_price"
              class="form-control total-cart-count"></div>
            @error('total_price')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 mb-3">
            <label for="total-return" class="form-label">Return</label>
            <div
              class="form-control total-return-count"></div>
            <input
              type="hidden"
              id="total-return"
              name="total_return"
              class="form-control"
              required
              readonly
              placeholder="Rp 0,00" />
            @error('total_return')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-span-12 d-block mt-2">
            <button class="btn btn-primary" style="width: 100%" type="submit">Checkout</button>
          </div>
        </div>  
      </div> 
    </div> 
</div>
</form>

@include('partials.modal-book-facility-admin')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/book-facility-admin.js') }}"></script>
<script>
  let customer = $(".customer-select2").select2()
</script>
@endpush