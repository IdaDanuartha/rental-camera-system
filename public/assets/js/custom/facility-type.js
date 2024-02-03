$(document).ready(function() {  
  $(".detail-type-data").on("click", function() {          
    $.ajax({
        type: "GET",
        url: `/facilities/types/${$(this).closest('.table-body').find('.facility_type_id').val()}`,              
        dataType: "json",
        success: function({facility_type}){              
          $("#detail_name").val(facility_type.name)
        }
    })
  })

  $(".edit-type-data").on("click", function() { 
    const facility_type_id = $(this).closest('.table-body').find('.facility_type_id').val()     
    $.ajax({
    type: "GET",
      url: `/facilities/types/${facility_type_id}`,
      dataType: "json",
      success: function({facility_type}){                   
        $("#edit_facility_type_form").attr("action", `/facilities/types/${facility_type.id}`)                
        $("#edit_name").val(facility_type.name)         
      }
    })
  })
  
  $(".btn-delete-type").attr("disabled", true)
  $(".delete-type-data").on("click", function() { 
    const facility_type_id = $(this).closest('.table-body').find('.facility_type_id').val()     
    $("#delete_type_form").attr("action", `/facilities/types/${facility_type_id}`)    
    $(".btn-delete-type").attr("disabled", false)
  })
})