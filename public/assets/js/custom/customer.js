$(document).ready(function() {  
  $(".btn-delete-customer").attr("disabled", true)
  
  $(".delete-customer-data").on("click", function() { 
    const customer_id = $(this).closest('.table-body').find('.customer_id').val()     
    $("#delete_customer_form").attr("action", `/customers/${customer_id}`)    
    $(".btn-delete-customer").attr("disabled", false)
  })
})