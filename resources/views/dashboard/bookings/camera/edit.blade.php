@extends('layouts.main')
@section('title', 'Edit Customer Page')

@section('main')
<form class="card" action="{{ route('customers.update', $customer->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <input type="hidden" id="authenticatable_type" name="authenticatable_type" value="App\Models\Customer"/>  

  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Edit Customer</h5>    
  </div>  
  <div class="mx-4 mb-4">
    <div class="row">
      <div class="col-6 mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          class="form-control"
          value="{{ $customer->name }}"
          required
          placeholder="Enter name" />
        @error('name')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          id="username"
          name="user[username]"
          class="form-control"
          value="{{ $customer->user->username }}"
          required
          placeholder="Enter username" />
        @error('user.username')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="text"
          id="email"
          name="user[email]"
          class="form-control"
          value="{{ $customer->user->email }}"
          required
          placeholder="Enter email" />
        @error('user.email')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="phone_number" class="form-label">Phone Number</label>
        <input
          type="text"
          id="phone_number"
          name="phone_number"
          class="form-control"
          value="{{ $customer->phone_number }}"
          placeholder="Enter phone number" />
        @error('phone_number')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          id="password"
          name="user[password]"
          class="form-control"                    
          placeholder="Enter password" />
        @error('user.password')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
			<div class="col-span-12 flex flex-col mb-3">
				<p class="text-second mb-1">Account Status</p>
				<label class="switch">
					<input type="checkbox" name="user[status]" @checked($customer->user->status->value == 1 ? 'on' : '')>
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
						<img src="{{ asset('uploads/customers/' . $customer->profile_image) }}" class="edit-customer-preview-img border" width="300" alt="">
					@else
						<img src="{{ asset('assets/img/upload-image.jpg') }}" class="edit-customer-preview-img border" width="300" alt="">
					@endif
        </label>
				<input
					type="file"
					id="profile_image"
					name="profile_image"
					class="form-control edit-customer-input"
					/>
				@error('profile_image')
					<div class="text-danger mt-1">{{ $message }}</div>
				@enderror
			</div>
			<div class="col-span-12 flex items-center gap-3 mt-2">
				<button class="btn btn-primary me-3" type="submit">Save Changes</button>
				<a href="{{ route('customers.index') }}" class="btn btn-secondary" type="reset">Cancel Edit</a>
			</div>
    </div>  
  </div>  
</form>
@endsection

@push('js')
  <script>
    previewImg("edit-customer-input", "edit-customer-preview-img")
  </script>
@endpush