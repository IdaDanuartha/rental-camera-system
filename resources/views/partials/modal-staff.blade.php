{{-- Create staff --}}
{{-- <div class="modal fade" id="createStaffModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="{{ route('categories.store') }}" method="post">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="createStaffModalTitle">Create New staff</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="name" class="form-label">staff Name</label>
            <input
              type="text"
              id="name"
              name="name"
              class="form-control"
              value="{{ old('name') }}"
              required
              placeholder="Enter name staff" />
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
</div> --}}

{{-- Detail staff --}}
{{-- <div class="modal fade" id="detailStaffModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content">      
      <div class="modal-header">
        <h5 class="modal-title" id="detailStaffModalTitle">Detail staff</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">      
        <div class="row">
          <div class="col mb-3">
            <label for="" class="form-label">staff Name</label>
            <input
              type="text"
              id="detail-name"
              class="form-control"
              readonly/>
          </div>
        </div>        
      </div>
    </form>
  </div>
</div> --}}

{{-- Edit staff --}}
{{-- <div class="modal fade" id="editStaffModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="" id="edit_staff_form" method="post">
      @csrf
      @method("PUT")
      <input type="hidden" id="edit_staff_id" name="staff_id">
      <div class="modal-header">
        <h5 class="modal-title" id="editStaffModalTitle">Edit staff</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="edit-name" class="form-label">staff Name</label>
            <input
              type="text"
              id="edit-name"
              name="name"
              class="form-control"
              required
              placeholder="Enter name staff" />
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
</div> --}}

{{-- Delete Staff --}}
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteStaffModalTitle">Delete Staff</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <p>Force Deletion Confirmation: Are you sure you want to delete
          this staff? This action cannot be reversed and the force will
          permanently deleted from the system.</p>      
      </div>
      <form action="" method="POST" id="delete_staff_form" class="modal-footer d-flex justify-content-center">
        @csrf
        @method("DELETE")
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary btn-delete-staff">Delete</button>
      </form>
    </div>
  </div>
</div>