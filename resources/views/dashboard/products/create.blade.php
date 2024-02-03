@extends('layouts.main')
@section('title', 'Add Product Page')

@section('main')
<form class="card" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Create New Product</h5>    
  </div>  
  <div class="mx-4 mb-4">
    <div class="row">
      <div class="col-12 mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          class="form-control"
          value="{{ old('name') }}"
          required
          placeholder="Enter name" />
        @error('name')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12 mb-3">
        <label for="device_series_id" class="form-label">Device Series</label>
            <select required class="device-series-select2 form-control" name="device_series_id">
              <option value="">Select Device Series</option>
              @foreach ($device_series as $item)
                @if (old('device_series_id') === $item->id)
                  <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                  <option value="{{ $item->id }}">{{ $item->name }}</option>  
                @endif
              @endforeach
            </select>
            @error('device_series_id')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="rental_price" class="form-label">Rental Price</label>
        <input
          type="number"
          id="rental_price"
          name="rental_price"
          class="form-control"
          value="{{ old('rental_price') }}"
          required
          placeholder="Enter rental_price" />
        @error('rental_price')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-6 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input
          type="text"
          id="stock"
          name="stock"
          class="form-control"
          value="{{ old('stock') }}"
          required
          placeholder="Enter stock" />
        @error('stock')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12 mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description">{{ old("description") }}</textarea>
        @error('description')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
			<div class="col-span-12 flex items-center gap-3 mt-2">
				<button class="btn btn-primary me-3" type="submit">Create Product</button>
				<a href="{{ route('products.index') }}" class="btn btn-secondary" type="reset">Cancel Add</a>
			</div>
    </div>  
  </div>  
</form>
@endsection

@push('js')
  <script>
    $('.device-series-select2').select2()

    previewImg("create-product-input", "create-product-preview-img")
    let description = new RichTextEditor("#description");
  </script>
@endpush