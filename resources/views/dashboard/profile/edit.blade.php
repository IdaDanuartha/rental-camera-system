@extends('layouts.main')
@section('title', 'Profile Page')

@section('main')
<form class="card" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-header">Edit Profile</h5>    
    </div>  
    <div class="mx-4 mb-4">
      <div class="row">
        <div class="row">
            <div class="col-md-3 col-span-12">
                <label for="profile_image" class="d-block mb-3">
                    @if (isset(auth()->user()->authenticatable->profile_image))
                        <img src="{{ asset('uploads/users/' . auth()->user()->authenticatable->profile_image) }}" class="edit-user-preview-img border rounded" width="100%" alt="">
                    @else
                        <img src="{{ asset('assets/img/avatars/1.png') }}" class="edit-user-preview-img border rounded" width="100%" alt="">
                    @endif
                </label>
                <input
					type="file"
					id="profile_image"
					name="profile_image"
					class="form-control edit-user-input"
					/>
				@error('profile_image')
					<div class="text-danger mt-1">{{ $message }}</div>
				@enderror
            </div>
            <div class="col-md-9 col-span-12 row">
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                      type="text"
                      id="name"
                      name="name"
                      class="form-control"
                      value="{{ auth()->user()->authenticatable->name }}"
                      placeholder="Enter name" />
                    @error('name')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                      type="text"
                      id="username"
                      name="user[username]"
                      class="form-control"
                      value="{{ auth()->user()->username }}"
                      placeholder="Enter username" />
                    @error('user.username')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input
                      type="email"
                      id="email"
                      name="user[email]"
                      class="form-control"
                      value="{{ auth()->user()->email }}"
                      placeholder="Enter email" />
                    @error('user.email')
                      <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                @if (!auth()->user()->isAdmin())
                    <div class="col-12 mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input
                        type="text"
                        id="phone_number"
                        name="phone_number"
                        class="form-control"
                        value="{{ auth()->user()->authenticatable->phone_number }}"
                        placeholder="Enter phone number" />
                    </div>
                  @error('phone_number')
                    <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                @endif
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Password</label>
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
            </div>
        </div>
        <div class="col-span-12 flex items-center gap-3 mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>  
    </div>  
  </form>
@endsection

@push('js')
  <script>
    previewImg("edit-user-input", "edit-user-preview-img")
  </script>
@endpush