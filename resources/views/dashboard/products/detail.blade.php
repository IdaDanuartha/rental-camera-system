@extends('layouts.main')
@section('title', 'Detail Product Page')

@section('main')
<form class="card">  
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Detail Product</h5>    
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary me-3">Edit</a>
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
          value="{{ $product->name }}"
          readonly />
      </div>
      <div class="col-6 mb-3">
        <label for="device_series" class="form-label">Device Series</label>
        <input
          type="text"
          id="device_series"
          name="device_series"
          class="form-control"
          value="{{ $product->deviceSeries->name }}"
          readonly />
      </div>
      <div class="col-6 mb-3">
        <label for="rental_price" class="form-label">Rental Price</label>
        <input
          type="number"
          id="rental_price"
          name="rental_price"
          class="form-control"
          value="{{ $product->rental_price }}"
          readonly />
      </div>
      <div class="col-6 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input
          type="text"
          id="stock"
          name="stock"
          class="form-control"
          value="{{ $product->stock }}"
          readonly />
      </div>
      <div class="col-12 mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" readonly>{{ $product->description }}</textarea>
      </div>
			<div class="col-span-12 flex items-center gap-3 mt-2">
				<a href="{{ route('products.index') }}" class="btn btn-secondary" type="reset">Back </a>
			</div>
    </div>   
  </div>  
</form>
@endsection

@push('js')
  <script>
    let description = new RichTextEditor("#description");
    description.setReadOnly(true)
  </script>
@endpush