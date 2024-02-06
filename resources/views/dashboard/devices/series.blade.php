@extends('layouts.main')
@section('title', 'Device Series Page')

@section('main')
<x-search-bar></x-search-bar>

<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Device Series</h5>
    <button type="button" data-bs-toggle="modal"
    data-bs-target="#createSeriesModal" class="btn btn-primary me-3">Add Device Series</button>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Brand</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($device_series as $item)        
          <tr class="table-body">
            <input type="hidden" class="device_series_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">{{ $item->deviceBrand->name }}</span>
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
                  <a class="dropdown-item detail-series-data" data-bs-toggle="modal"
                  data-bs-target="#detailSeriesModal"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item edit-series-data" data-bs-toggle="modal"
                  data-bs-target="#editSeriesModal"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-series-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteSeriesModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Device Series not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $device_series->links() }}
    </div>
  </div>
</div>

@include('partials.modal-device-series')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/device-series.js') }}"></script>
@endpush