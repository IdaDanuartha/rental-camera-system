{{-- Delete Customer --}}
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCustomerModalTitle">Delete Customer</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">  
        <p>Force Deletion Confirmation: Are you sure you want to delete
          this customer? This action cannot be reversed and the force will
          permanently deleted from the system.</p>      
      </div>
      <form action="" method="POST" id="delete_customer_form" class="modal-footer d-flex justify-content-center">
        @csrf
        @method("DELETE")
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary btn-delete-customer">Delete</button>
      </form>
    </div>
  </div>
</div>