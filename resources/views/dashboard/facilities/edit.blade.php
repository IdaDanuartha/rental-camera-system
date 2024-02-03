@extends('layouts.main')
@section('title', 'Edit Facility Page')

@section('main')
<form class="card" action="{{ route('facilities.index.update', $facility->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Edit Facility</h5>    
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
          value="{{ $facility->name }}"
          required
          placeholder="Enter name" />
        @error('name')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-lg-4 col-12 mb-3">
        <label for="facility_type_id" class="form-label">Device Series</label>
            <select required class="facility-type-select2 form-control" name="facility_type_id">
              <option value="">Select Device Series</option>
              @foreach ($facility_types as $item)
                @if ($facility->facility_type_id === $item->id)
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
          value="{{ $facility->rental_price }}"
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
          value="{{ $facility->stock }}"
          required
          placeholder="Enter stock" />
        @error('stock')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12 mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description">{{ $facility->description }}</textarea>
        @error('description')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
			<div class="col-span-12 flex items-center gap-3 mt-2">
				<button class="btn btn-primary me-3" type="submit">Save Changes</button>
				<a href="{{ route('facilities.index.index') }}" class="btn btn-secondary">Cancel Save</a>
			</div>
    </div> 
  </div>  
</form>
@endsection

@push('js')
  <script>
    $('.facility-type-select2').select2()

    previewImg("create-facility-input", "create-facility-preview-img")
    let description = new RichTextEditor("#description");
  </script>
@endpush