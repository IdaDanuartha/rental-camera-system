{{-- Create Device Series --}}
<div class="modal fade" id="createSeriesModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="{{ route('devices.series.store') }}" method="post">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="createSeriesModalTitle">Create New Device Series</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
              placeholder="Enter device brand name" />
            @error('name')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 mb-3">
            <label for="device_brand_id" class="form-label">Device Brand</label>
            <select required class="device-series-select2 form-control" name="device_brand_id">
              <option value="">Select Type</option>
              @foreach ($device_brands as $item)
                @if (old('device_brand_id') === $item->id)
                  <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                  <option value="{{ $item->id }}">{{ $item->name }}</option>  
                @endif
              @endforeach
            </select>
            @error('device_brand_id')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- Detail Device Series --}}
<div class="modal fade" id="detailSeriesModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content">      
      <div class="modal-header">
        <h5 class="modal-title" id="detailSeriesModalTitle">Detail Device Series</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">      
        <div class="row">
          <div class="col-12 mb-3">
            <label for="" class="form-label">Name</label>
            <input
              type="text"
              id="detail_name"
              class="form-control"
              readonly/>
          </div>
          <div class="col-12 mb-3">
            <label for="" class="form-label">Brand</label>
            <input
              type="text"
              id="detail_device_brand"
              class="form-control"
              readonly/>
          </div>
        </div>        
      </div>
    </form>
  </div>
</div>

{{-- Edit Device Series --}}
<div class="modal fade" id="editSeriesModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="" id="edit_series_form" method="post">
      @csrf
      @method("PUT")      
      <div class="modal-header">
        <h5 class="modal-title" id="editSeriesModalTitle">Edit Device Series</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input
              type="text"
              id="edit_name"
              name="name"
              class="form-control"
              required
              placeholder="Enter device brand name" />
            @error('name')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="row">
            <div class="col-12 mb-3">
              <label for="device_brand_id" class="form-label">Device Brand</label>
              <select id="edit_device_brand" required class="edit-device-series-select2 form-control" name="device_brand_id">              
              </select>
              @error('device_brand_id')
                <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>

{{-- Delete Device Series --}}
<div class="modal fade" id="deleteSeriesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteSeriesModalTitle">Delete Device Series</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <p>Force Deletion Confirmation: Are you sure you want to delete
          this device series? This action cannot be reversed and the force will
          permanently deleted from the system.</p>      
      </div>
      <form action="" method="POST" id="delete_series_form" class="modal-footer d-flex justify-content-center">
        @csrf
        @method("DELETE")
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary btn-delete-series">Delete</button>
      </form>
    </div>
  </div>
</div>