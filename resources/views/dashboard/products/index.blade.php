@extends('layouts.main')
@section('title', 'Product Page')

@section('main')
<x-search-bar></x-search-bar>

<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Product</h5>
    <a href="{{ route('products.create') }}" class="btn btn-primary me-3">Add Product</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Brand</th>
          <th>Series</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($products as $item)        
          <tr class="table-body">
            <input type="hidden" class="product_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">{{ $item->deviceSeries->deviceBrand->name }}</span>
            </td>
            <td>              
              <span class="fw-medium">{{ $item->deviceSeries->name }}</span>
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
                  <a href="{{ route('products.show', $item->id) }}" class="dropdown-item detail-product-data"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a href="{{ route('products.edit', $item->id) }}" class="dropdown-item edit-product-data"
                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                  >
                  <a class="dropdown-item delete-product-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteProductModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Product not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $products->links() }}
    </div>
  </div>
</div>

@include('partials.modal-product')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/product.js') }}"></script>
@endpush