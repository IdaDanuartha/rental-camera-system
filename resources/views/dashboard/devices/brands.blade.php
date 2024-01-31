@extends('layouts.main')
@section('title', 'Device Brand Page')

@section('main')
<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Device Brand</h5>
    <button type="button" data-bs-toggle="modal"
    data-bs-target="#createBrandModal" class="btn btn-primary me-3">Add Device Brand</button>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Type</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($device_brands as $item)        
          <tr class="table-body">
            <input type="hidden" class="device_brand_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">{{ $item->deviceType->name }}</span>
            </td>
            <td>              
              <span class="fw-medium">{{ $item->name }}</span>
            </td>                
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item detail-brand-data" data-bs-toggle="modal"
                  data-bs-target="#detailBrandModal"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item edit-brand-data" data-bs-toggle="modal"
                  data-bs-target="#editBrandModal"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-brand-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteBrandModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Device Brand not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $device_brands->links() }}
    </div>
  </div>
</div>

@include('partials.modal-device-brand')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/device-brand.js') }}"></script>
@endpush