$(document).ready(function() {  
  $(".detail-type-data").on("click", function() {          
    $.ajax({
        type: "GET",
        url: `/devices/types/${$(this).closest('.table-body').find('.device_type_id').val()}`,              
        dataType: "json",
        success: function({device_type}){              
          $("#detail_name").val(device_type.name)
        }
    })
  })

  $(".edit-type-data").on("click", function() { 
    const device_type_id = $(this).closest('.table-body').find('.device_type_id').val()     
    $.ajax({
    type: "GET",
      url: `/devices/types/${device_type_id}`,
      dataType: "json",
      success: function({device_type}){                   
        $("#edit_device_type_form").attr("action", `/devices/types/${device_type.id}`)                
        $("#edit_name").val(device_type.name)         
      }
    })
  })
  
  $(".btn-delete-type").attr("disabled", true)
  $(".delete-type-data").on("click", function() { 
    const device_type_id = $(this).closest('.table-body').find('.device_type_id').val()     
    $("#delete_type_form").attr("action", `/devices/types/${device_type_id}`)    
    $(".btn-delete-type").attr("disabled", false)
  })
})