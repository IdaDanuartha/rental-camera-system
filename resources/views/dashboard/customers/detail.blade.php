@extends('layouts.main')
@section('title', 'Detail Customer Page')

@section('main')
<form class="card">  
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Detail Customer</h5>    
    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary me-3">Edit</a>
  </div>  
  <div class="mx-4 mb-4">
    <div class="row">
      <div class="col-6 mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          value="{{ $customer->name }}"
          readonly/>
      </div>
      <div class="col-6 mb-3">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          value="{{ $customer->user->username }}"
          readonly/>
      </div>
      <div class="col-6 mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="text"
          class="form-control"
          value="{{ $customer->user->email }}"
          readonly/>
      </div>
      <div class="col-6 mb-3">
        <label for="phone_number" class="form-label">Phone Number</label>
        <input
          type="text"
          id="phone_number"
          name="phone_number"
          class="form-control"
          value="{{ $customer->phone_number }}"
          readonly/>
      </div>
			<div class="col-span-12 flex flex-col mb-3">
				<p class="text-second mb-1">Account Status</p>
				<label class="switch">
					<input type="checkbox" disabled @checked($customer->user->status->value == 1 ? 'on' : '')>
					<span class="slider round"></span>
				</label>

				@error('user.status')
					<div class="text-danger mt-1">{{ $message }}</div>
				@enderror
			</div>
      <div class="col-3 flex flex-col mb-3">
				<label for="profile_image" class="text-second mb-1">Profile Photo</label>
				<label for="profile_image" class="d-block mb-3">
          @if ($customer->profile_image)
            <img src="{{ asset('uploads/customers/' . $customer->profile_image) }}" class="border" width="300" alt="">
          @else
            <img src="{{ asset('assets/img/upload-image.jpg') }}" class="border" width="300" alt="">
          @endif
				</label>
			</div>
			<div class="col-span-12 flex items-center gap-3 mt-2">				
				<a href="{{ route('customers.index') }}" class="btn btn-secondary" type="reset">Back</a>
			</div>
    </div>  
  </div>  
</form>
@endsection