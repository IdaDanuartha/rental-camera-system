@extends('layouts.main')
@section('title', 'Profile Page')

@section('main')
<form class="card">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="card-header">My Profile</h5>    
    </div>  
    <div class="mx-4 mb-4">
      <div class="row">
        <div class="row">
            <div class="col-md-3 col-span-12">
                {{-- <label for="profile_image" class="text-second mb-1"></label> --}}
                <label for="profile_image" class="d-block mb-3">
                  @if (isset(auth()->user()->authenticatable->profile_image))
                    <img src="{{ asset('uploads/users/' . auth()->user()->authenticatable->profile_image) }}" class="edit-user-preview-img border rounded" width="100%" alt="">
                  @else
                    <img src="{{ asset('assets/img/avatars/1.png') }}" class="edit-user-preview-img border rounded" width="100%" alt="">
                  @endif
                </label>
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
                      readonly
                      placeholder="Enter name" />
                </div>
                <div class="col-12 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                      type="text"
                      id="username"
                      name="username"
                      class="form-control"
                      value="{{ auth()->user()->username }}"
                      readonly
                      placeholder="Enter username" />
                </div>
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      class="form-control"
                      value="{{ auth()->user()->email }}"
                      readonly
                      placeholder="Enter email" />
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
                        readonly
                        placeholder="Enter phone number" />
                    </div>
                @endif
            </div>
        </div>
        <div class="col-span-12 flex items-center gap-3 mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
      </div>  
    </div>  
  </form>
@endsection