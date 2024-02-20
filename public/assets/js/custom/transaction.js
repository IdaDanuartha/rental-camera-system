$(document).ready(function() {  
  let status_select2 = $(".edit-status-camera-select2").select2({
    dropdownParent: $("#editTransactionCameraModal")
  })
  let status_facility_select2 = $(".edit-status-facility-select2").select2({
    dropdownParent: $("#editTransactionFacilityModal")
  })

  $(".edit-transaction-camera-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $.ajax({
    type: "GET",
      url: `/booking/cameras/${transaction_id}/edit`,
      dataType: "json",
      success: function({camera}){    
        console.log(camera)
        $("#edit_transaction_camera_form").attr("action", `/booking/cameras/${camera.id}`)                        
        const status = ["Rented", "Returned"]

        status.forEach((sts, index) => {          
          if(index+1 == camera.status) {
            $("#edit_status_camera").append(`
              <option value="${index+1}" selected>
                  ${sts}
              </option>
          `)
          } else {
            $("#edit_status_camera").append(`
              <option value="${index+1}">
                  ${sts}
              </option>
          `)
          }
        });
      }
    })
  })

  $(".edit-transaction-facility-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $.ajax({
    type: "GET",
      url: `/booking/facilities/${transaction_id}/edit`,
      dataType: "json",
      success: function({facility}){    
        console.log(facility)
        $("#edit_transaction_facility_form").attr("action", `/booking/facilities/${facility.id}`)                        
        const status = ["Rented", "Returned"]

        status.forEach((sts, index) => {          
          if(index+1 == facility.status) {
            $("#edit_status_facility").append(`
              <option value="${index+1}" selected>
                  ${sts}
              </option>
          `)
          } else {
            $("#edit_status_facility").append(`
              <option value="${index+1}">
                  ${sts}
              </option>
          `)
          }
        });
      }
    })
  })

  $(".btn-delete-transaction-camera").attr("disabled", true)
  
  $(".delete-transaction-camera-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $("#delete_transaction_camera_form").attr("action", `/booking/cameras/${transaction_id}`)    
    $(".btn-delete-transaction-camera").attr("disabled", false)
  })

  $(".btn-delete-transaction-facility").attr("disabled", true)
  
  $(".delete-transaction-facility-data").on("click", function() { 
    const transaction_id = $(this).closest('.table-body').find('.transaction_id').val()     
    $("#delete_transaction_facility_form").attr("action", `/booking/facilities/${transaction_id}`)    
    $(".btn-delete-transaction-facility").attr("disabled", false)
  })
})