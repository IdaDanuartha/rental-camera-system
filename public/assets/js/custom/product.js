$(document).ready(function() {  
  $(".btn-delete-product").attr("disabled", true)
  
  $(".delete-product-data").on("click", function() { 
    const product_id = $(this).closest('.table-body').find('.product_id').val()     
    $("#delete_product_form").attr("action", `/products/${product_id}`)    
    $(".btn-delete-product").attr("disabled", false)
  })
})