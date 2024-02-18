$(document).ready(function() {  
  $(".btn-delete-order-camera").attr("disabled", true)
  
  $(".delete-order-camera-data").on("click", function() { 
    const order_id = $(this).closest('.table-body').find('.order_id').val()     
    $("#delete_order_camera_form").attr("action", `/orders/camera/${order_id}`)    
    $(".btn-delete-order-camera").attr("disabled", false)
  })

  $(".btn-delete-order-facility").attr("disabled", true)
  $(".delete-order-facility-data").on("click", function() { 
    const order_id = $(this).closest('.table-body').find('.order_id').val()     
    $("#delete_order_facility_form").attr("action", `/orders/facility/${order_id}`)    
    $(".btn-delete-order-facility").attr("disabled", false)
  })
})