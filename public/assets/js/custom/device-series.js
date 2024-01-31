$(document).ready(function() {  
  $('.device-series-select2').select2({
    dropdownParent: $("#createSeriesModal")
  });

  $('.edit-device-series-select2').select2({
    dropdownParent: $("#editSeriesModal")
  });

  $(".detail-series-data").on("click", function() {          
    $.ajax({
        type: "GET",
        url: `/devices/series/${$(this).closest('.table-body').find('.device_series_id').val()}`,              
        dataType: "json",
        success: function({device_series}){              
          $("#detail_name").val(device_series.name)
          $("#detail_device_brand").val(device_series.device_brand.name)
        }
    })
  })

  $(".edit-series-data").on("click", function() { 
    const device_series_id = $(this).closest('.table-body').find('.device_series_id').val()     
    $.ajax({
    type: "GET",
      url: `/devices/series/${device_series_id}`,
      dataType: "json",
      success: function({device_series, device_brands}){                   
        $("#edit_series_form").attr("action", `/devices/series/${device_series.id}`)                
        $("#edit_name").val(device_series.name)         

        device_brands.forEach(type => {          
          if(type.id == device_series.device_brand_id) {
            $("#edit_device_brand").append(`
              <option value="${type.id}" selected>
                  ${type.name}
              </option>
          `)
          } else {
            $("#edit_device_brand").append(`
              <option value="${type.id}">
                  ${type.name}
              </option>
          `)
          }
        });
      }
    })
  })
  
  $(".btn-delete-series").attr("disabled", true)
  $(".delete-series-data").on("click", function() { 
    const device_series_id = $(this).closest('.table-body').find('.device_series_id').val()     
    $("#delete_series_form").attr("action", `/devices/series/${device_series_id}`)    
    $(".btn-delete-series").attr("disabled", false)
  })
})