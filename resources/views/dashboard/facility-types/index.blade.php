@extends('layouts.main')
@section('title', 'Facility Type Page')

@section('main')
<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Facility Type</h5>
    <button type="button" data-bs-toggle="modal"
    data-bs-target="#createTypeModal" class="btn btn-primary me-3">Add Facility Type</button>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($facility_types as $item)        
          <tr class="table-body">
            <input type="hidden" class="facility_type_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">{{ $item->name }}</span>
            </td>                
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item detail-type-data" data-bs-toggle="modal"
                  data-bs-target="#detailTypeModal"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item edit-type-data" data-bs-toggle="modal"
                  data-bs-target="#editTypeModal"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-type-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteTypeModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Facility Type not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $facility_types->links() }}
    </div>
  </div>
</div>

@include('partials.modal-facility-type')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/facility-type.js') }}"></script>
@endpush