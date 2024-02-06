@extends('layouts.main')
@section('title', 'Staff Page')

@section('main')
<x-search-bar></x-search-bar>

<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Staff</h5>
    <a href="{{ route('staff.create') }}" class="btn btn-primary me-3">Add Staff</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($staff as $item)        
          <tr class="table-body">
            <input type="hidden" class="staff_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">{{ $item->name }}</span>
            </td>
            <td>
              <span class="fw-medium">{{ $item->user->username }}</span>
            </td>
            <td>
              <span class="fw-medium">{{ $item->user->email }}</span>
            </td>
            <td>
              <span class="fw-medium">{{ $item->phone_number }}</span>
            </td>                    
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('staff.show', $item->id) }}"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item" href="{{ route('staff.edit', $item->id) }}"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-staff-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteStaffModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Staff not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $staff->links() }}
    </div>
  </div>
</div>

@include('partials.modal-staff')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/staff.js') }}"></script>
@endpush