$(document).ready(function() {  
  $(".btn-delete-order").attr("disabled", true)
  
  $(".delete-order-data").on("click", function() { 
    const order_id = $(this).closest('.table-body').find('.order_id').val()     
    $("#delete_order_form").attr("action", `/orders/${order_id}`)    
    $(".btn-delete-order").attr("disabled", false)
  })
})