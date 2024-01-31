$(document).ready(function() {  
  $(".btn-delete-staff").attr("disabled", true)

  $(".delete-staff-data").on("click", function() { 
    const staff_id = $(this).closest('.table-body').find('.staff_id').val()     
    $("#delete_staff_form").attr("action", `/staff/${staff_id}`)    
    $(".btn-delete-staff").attr("disabled", false)
  })
})