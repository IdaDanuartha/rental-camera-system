$(document).ready(function() {  
  $(".btn-delete-facility").attr("disabled", true)
  
  $(".delete-facility-data").on("click", function() { 
    const facility_id = $(this).closest('.table-body').find('.facility_id').val()     
    $("#delete_facility_form").attr("action", `/facilities/index/${facility_id}`)    
    $(".btn-delete-facility").attr("disabled", false)
  })
})