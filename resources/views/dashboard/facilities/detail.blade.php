@extends('layouts.main')
@section('title', 'Detail Facility Page')

@section('main')
<form class="card">  
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Detail Facility</h5>    
    <a href="{{ route('facilities.index.edit', $facility->id) }}" class="btn btn-primary me-3">Edit</a>
  </div>  
  <div class="mx-4 mb-4">
    <div class="row">
      <div class="col-12 mb-3">
        <label for="" class="form-label">Facility Images</label>
        <div class="flex mb-3">
          <div class="mb-4">
            @foreach ($facility->facilityImages as $image)
              <img src="{{ asset('uploads/facilities/' . $image->image) }}" class="border mr-4 mb-4" width="200px" alt="">
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          class="form-control"
          value="{{ $facility->name }}"
          readonly />
      </div>
      <div class="col-lg-4 col-12 mb-3">
        <label for="facility_type" class="form-label">Facility Type</label>
        <input
          type="text"
          id="facility_type"
          name="facility_type"
          class="form-control"
          value="{{ $facility->facilityType->name }}"
          readonly />
      </div>
      <div class="col-lg-4 col-12 mb-3">
        <label for="rental_price" class="form-label">Rental Price</label>
        <input
          type="number"
          id="rental_price"
          name="rental_price"
          class="form-control"
          value="{{ $facility->rental_price }}"
          readonly />
      </div>
      <div class="col-lg-4 col-12 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input
          type="text"
          id="stock"
          name="stock"
          class="form-control"
          value="{{ $facility->stock }}"
          readonly />
      </div>
      <div class="col-12 mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" readonly>{{ $facility->description }}</textarea>
      </div>
			<div class="col-span-12 flex items-center gap-3 mt-2">
				<a href="{{ route('facilities.index.index') }}" class="btn btn-secondary" type="reset">Back </a>
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