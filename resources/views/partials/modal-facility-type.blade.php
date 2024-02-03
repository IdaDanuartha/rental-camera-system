{{-- Create Facility Type --}}
<div class="modal fade" id="createTypeModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="{{ route('facilities.types.store') }}" method="post">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="createTypeModalTitle">Create New Facility Type</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="name" class="form-label">Name</label>
            <input
              type="text"
              id="name"
              name="name"
              class="form-control"
              value="{{ old('name') }}"
              required
              placeholder="Enter facility type name" />
            @error('name')
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

{{-- Detail Facility Type --}}
<div class="modal fade" id="detailTypeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content">      
      <div class="modal-header">
        <h5 class="modal-title" id="detailTypeModalTitle">Detail Facility Type</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">      
        <div class="row">
          <div class="col mb-3">
            <label for="" class="form-label">Name</label>
            <input
              type="text"
              id="detail_name"
              class="form-control"
              readonly/>
          </div>
        </div>        
      </div>
    </form>
  </div>
</div>

{{-- Edit Facility Type --}}
<div class="modal fade" id="editTypeModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="" id="edit_facility_type_form" method="post">
      @csrf
      @method("PUT")      
      <div class="modal-header">
        <h5 class="modal-title" id="editTypeModalTitle">Edit Facility Type</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="edit_name" class="form-label">Name</label>
            <input
              type="text"
              id="edit_name"
              name="name"
              class="form-control"
              required
              placeholder="Enter facility type name" />
            @error('name')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
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

{{-- Delete Facility Type --}}
<div class="modal fade" id="deleteTypeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTypeModalTitle">Delete Facility Type</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <p>Force Deletion Confirmation: Are you sure you want to delete
          this facility type? This action cannot be reversed and the force will
          permanently deleted from the system.</p>      
      </div>
      <form action="" method="POST" id="delete_type_form" class="modal-footer d-flex justify-content-center">
        @csrf
        @method("DELETE")
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary btn-delete-type">Delete</button>
      </form>
    </div>
  </div>
</div>