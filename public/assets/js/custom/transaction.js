$(document).ready(function() {  
  $(".btn-delete-transaction-camera").attr("disabled", true)
  
  $(".delete-transaction-camera-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $("#delete_transaction_camera_form").attr("action", `/bookings/cameras/${transaction_id}`)    
    $(".btn-delete-transaction-camera").attr("disabled", false)
  })

  $(".btn-delete-transaction-facility").attr("disabled", true)
  
  $(".delete-transaction-facility-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $("#delete_transaction_facility_form").attr("action", `/bookings/facilities/${transaction_id}`)    
    $(".btn-delete-transaction-facility").attr("disabled", false)
  })
})