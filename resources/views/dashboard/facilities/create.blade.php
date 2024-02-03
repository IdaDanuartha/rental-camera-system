@extends('layouts.main')
@section('title', 'Add Facility Page')

@section('main')
<form class="card" action="{{ route('facilities.index.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Create New Facility</h5>    
  </div>  
  <div class="mx-4 mb-4">
    <div class="row">
      <div class="col-12 mb-3">
        <label for="images" class="form-label">Facility Images (Upload multiple images)</label>
        <div class="row multiple-preview-images mb-3">
          <label for="images" class="col-3">
            <img src="{{ asset('assets/img/upload-image.jpg') }}" class="border" width="200px" alt="">
          </label>
        </div>
        <input
          type="file"
          id="images"
          name="images[]"
          class="form-control create-facility-multiple-images"
          required
          multiple
          />
        @error('images')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
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
      <div class="col-lg-4 col-12 mb-3">
        <label for="facility_type_id" class="form-label">Facility Type</label>
            <select required class="facility-type-select2 form-control" name="facility_type_id">
              <option value="">Select Facility Type</option>
              @foreach ($facility_types as $item)
                @if (old('facility_type_id') === $item->id)
                  <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                  <option value="{{ $item->id }}">{{ $item->name }}</option>  
                @endif
              @endforeach
            </select>
            @error('facility_type_id')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
      </div>
      <div class="col-lg-4 col-12 mb-3">
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
      <div class="col-lg-4 col-12 mb-3">
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
				<button class="btn btn-primary me-3" type="submit">Create Facility</button>
				<a href="{{ route('facilities.index.index') }}" class="btn btn-secondary" type="reset">Cancel Add</a>
			</div>
    </div>  
  </div>  
</form>
@endsection

@push('js')
  <script>
    $('.facility-type-select2').select2()

    previewMultipleImages("create-facility-multiple-images", "multiple-preview-images")
    let description = new RichTextEditor("#description");
  </script>
@endpush