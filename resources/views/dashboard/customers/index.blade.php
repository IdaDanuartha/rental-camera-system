@extends('layouts.main')
@section('title', 'Customer Page')

@section('main')
<x-search-bar></x-search-bar>

<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Customer</h5>
    <a href="{{ route('customers.create') }}" class="btn btn-primary me-3">Add Customer</a>
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
        @forelse ($customers as $item)        
          <tr class="table-body">
            <input type="hidden" class="customer_id" value="{{ $item->id }}">
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
              <span class="fw-medium">{{ $item->phone_number ?? '-' }}</span>
            </td>                    
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('customers.show', $item->id) }}"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item" href="{{ route('customers.edit', $item->id) }}"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-customer-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteCustomerModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Customer not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $customers->links() }}
    </div>
  </div>
</div>

@include('partials.modal-customer')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/customer.js') }}"></script>
@endpush