@extends('layouts.main')
@section('title', 'Facility Page')

@section('main')
<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Facility</h5>
    <a href="{{ route('facilities.index.create') }}" class="btn btn-primary me-3">Add Facility</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Type</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($facilities as $item)        
          <tr class="table-body">
            <input type="hidden" class="facility_id" value="{{ $item->id }}">
            <td>              
              <span class="fw-medium">{{ $item->facilityType->name }}</span>
            </td>                
            <td>              
              <span class="fw-medium">{{ $item->name }}</span>
            </td>                
            <td>              
              <span class="fw-medium">@rupiah($item->rental_price)/day</span>
            </td>                
            <td>              
              <span class="fw-medium">{{ $item->stock }}</span>
            </td>                
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a href="{{ route('facilities.index.show', $item->id) }}" class="dropdown-item detail-facility-data"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a href="{{ route('facilities.index.edit', $item->id) }}" class="dropdown-item edit-facility-data"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-facility-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteFacilityModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Facility not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $facilities->links() }}
    </div>
  </div>
</div>

@include('partials.modal-facility')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/facility.js') }}"></script>
@endpush