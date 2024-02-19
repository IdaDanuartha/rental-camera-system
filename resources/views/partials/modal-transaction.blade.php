{{-- Delete Transaction Camera --}}
<div class="modal fade" id="deleteTransactionCameraModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTransactionCameraModalTitle">Delete Transaction Camera</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <p>Force Deletion Confirmation: Are you sure you want to delete
          this transaction? This action cannot be reversed and the force will
          permanently deleted from the system.</p>      
      </div>
      <form action="" method="POST" id="delete_transaction_camera_form" class="modal-footer d-flex justify-content-center">
        @csrf
        @method("DELETE")
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary btn-delete-transaction-camera">Delete</button>
      </form>
    </div>
  </div>
</div>

{{-- Delete Transaction Facility --}}
<div class="modal fade" id="deleteTransactionFacilityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteTransactionFacilityModalTitle">Delete Transaction Facility</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">  
          <p>Force Deletion Confirmation: Are you sure you want to delete
            this transaction? This action cannot be reversed and the force will
            permanently deleted from the system.</p>      
        </div>
        <form action="" method="POST" id="delete_transaction_facility_form" class="modal-footer d-flex justify-content-center">
          @csrf
          @method("DELETE")
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary btn-delete-transaction-facility">Delete</button>
        </form>
      </div>
    </div>
  </div>