$(document).ready(function() {  
  $('.device-type-select2').select2({
    dropdownParent: $("#createBrandModal")
  });

  $('.edit-device-type-select2').select2({
    dropdownParent: $("#editBrandModal")
  });

  $(".detail-brand-data").on("click", function() {          
    $.ajax({
        type: "GET",
        url: `/devices/brands/${$(this).closest('.table-body').find('.device_brand_id').val()}`,              
        dataType: "json",
        success: function({device_brand}){              
          $("#detail_name").val(device_brand.name)
          $("#detail_device_type").val(device_brand.device_type.name)
        }
    })
  })

  $(".edit-brand-data").on("click", function() { 
    const device_brand_id = $(this).closest('.table-body').find('.device_brand_id').val()     
    $.ajax({
    type: "GET",
      url: `/devices/brands/${device_brand_id}`,
      dataType: "json",
      success: function({device_brand, device_types}){                   
        $("#edit_brand_form").attr("action", `/devices/brands/${device_brand.id}`)                
        $("#edit_name").val(device_brand.name)         

        device_types.forEach(type => {          
          if(type.id == device_brand.device_type_id) {
            $("#edit_device_type").append(`
              <option value="${type.id}" selected>
                  ${type.name}
              </option>
          `)
          } else {
            $("#edit_device_type").append(`
              <option value="${type.id}">
                  ${type.name}
              </option>
          `)
          }
        });
      }
    })
  })
  
  $(".btn-delete-brand").attr("disabled", true)
  $(".delete-brand-data").on("click", function() { 
    const device_brand_id = $(this).closest('.table-body').find('.device_brand_id').val()     
    $("#delete_brand_form").attr("action", `/devices/brands/${device_brand_id}`)    
    $(".btn-delete-brand").attr("disabled", false)
  })
})