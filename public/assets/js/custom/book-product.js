$(document).ready(function() {  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function getProductCarts()
  {
    $.ajax({
      type: "GET",
      url: `/carts/products`,            
      dataType: "json",
      success: function({product_carts}){   
        console.log(product_carts)
        $(".cart-count").html(product_carts.length)
        let total = 0

        $("#product_carts").html("")
        if(product_carts.length > 0) {
          product_carts.forEach((cart, index) => {
            total += cart.product.rental_price * cart.qty
            $("#product_carts").append(`
            <div class="product-cart">
              <input type="hidden" class="product_cart_id" value="${cart.id}" />
              <div class="d-flex">
                  <img src="/uploads/products/${cart.product.product_images[0].image}" class="rounded" width="80" alt="">
                  <div class="ms-3 flex flex-col">
                      <h5 class="">${cart.product.name}</h5>
                      <div class="d-flex align-items-center">
                          <p>${rupiah(cart.product.rental_price)}</p>
                          <p class="mx-2">x</p>
                          <p>${cart.qty} day</p>
                      </div>
                      <a href="#" class="text-dark delete-product-cart-btn remove-btn"><i class='bx bx-trash bx-flip-horizontal' ></i></a>
                  </div>
              </div>
              <div class="card mt-2 mb-4">
                  <div class="card-body">
                    <label for="">Booking Date</label>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <input type="date" class="form-control start-book-input me-2" value="${formatInputDate(cart.booking_date)}" />
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <input type="date" class="form-control end-book-input me-2" value="${formatInputDate(cart.return_date)}" />
                    </div>
                    <div class="d-flex justify-content-between border-bottom mt-3">
                      <p class="card-text">Subtotal</p>
                      <p class="card-text">${rupiah(cart.product.rental_price * cart.qty)}</p>
                    </div>
                  </div>
              </div>
            </div>
            `)
          })

          $(".total-cart-count").html(rupiah(total))
          $(".checkout-container").removeClass("d-none")
        } else {
          $("#product_carts").html(`
          <div class="card mt-2 mb-4">
              <div class="card-body">
                <div class="text-center">
                  <p class="card-text">Belum ada produk di keranjang</p>
                </div>
              </div>
          </div>
          `)
          $(".checkout-container").addClass("d-none")
        }        

        $(".start-book-input").on("change", function() {
          const start_date = new Date($(".start-book-input").val())   
          const end_date = new Date($(".end-book-input").val())

          let total_time = end_date.getTime() - start_date.getTime();
          let total_days = Math.round(total_time / (1000 * 3600 * 24));

          $.ajax({
              type: "PUT",
              url: `/carts/products/${$(this).closest('.product-cart').find('.product_cart_id').val()}/change-booking-date`,  
              data: {
                total_days: total_days,
                start_date: $(this).val(),
                end_date: $(".end-book-input").val(),
              } ,         
              dataType: "json",
              success: function(response){
                getProductCarts()
              }
          })
        })

        $(".end-book-input").on("change", function() {
          const start_date = new Date($(".start-book-input").val())   
          const end_date = new Date($(".end-book-input").val())

          let total_time = end_date.getTime() - start_date.getTime();
          let total_days = Math.round(total_time / (1000 * 3600 * 24));

          console.log(total_days, $(".start-book-input").val(), $(".end-book-input").val())
          $.ajax({
              type: "PUT",
              url: `/carts/products/${$(this).closest('.product-cart').find('.product_cart_id').val()}/change-booking-date`,  
              data: {
                total_days: total_days,
                start_date: $(".start-book-input").val(),
                end_date: $(this).val(),
              } ,         
              dataType: "json",
              success: function(response){
                getProductCarts()
              }
          })
        })

        $(".delete-product-cart-btn").on("click", function() {  
          $.ajax({
              type: "DELETE",
              url: `/carts/products/${$(this).closest('.product-cart').find('.product_cart_id').val()}`,            
              dataType: "json",
              success: function(response){
                getProductCarts()
              }
          })
        })

        $(".total-pay-input").on("change", function() {
          let total_return = $(".total-pay-input").val() - total
          $(".total-return-count").html(rupiah(total_return))
          $("#total-return").val(total_return)
          $("#total-price").val(total)
        })
      }
    })
  }

  getProductCarts()

  $(".detail-product-data").on("click", function() {   
    $.ajax({
        type: "GET",
        url: `/products/${$(this).closest('.product-card').find('.product_id').val()}/json`,              
        dataType: "json",
        success: function({product}){   
          $("#detail_name").html(product.name)
          $("#detail_stock").html(product.stock)
          $("#detail_rental_price").html(rupiah(product.rental_price))
          $("#detail_description").html(product.description)

          const product_images = product.product_images

          $("#detail_product_images .swiper-wrapper").html("")
          product_images.forEach(image => {
            $("#detail_product_images .swiper-wrapper").append(`
              <div class="swiper-slide">
                <img class="rounded" src="/uploads/products/${image.image}" width="100%" alt="">
              </div>
            `)
          })
        }
    })
  })
  $(".add-to-cart-btn").on("click", function() {   
    $.ajax({
        type: "POST",
        url: `/carts/products`,
        data: {
          "product_id": `${$(this).closest('.product-card').find('.product_id').val()}`
         },             
        dataType: "json",
        success: function(response){   
          getProductCarts()
        }
    })
  })
})

let swiper = new Swiper(".produtImage", {
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

/**
 * <div class="d-flex align-items-center border rounded-3 px-2 py-1">
        <a href="#" class="text-dark cart-decrement-btn">
            <i class='bx bx-minus bx-flip-horizontal' ></i>
        </a>
        <input type="number" disabled class="input-qty" min="1" value="${cart.qty}" style="width: 50px">
        <a href="#" class="text-dark cart-increment-btn">
            <i class='bx bx-plus bx-flip-horizontal' ></i>
        </a>
    </div>
    <a href="#" class="text-dark delete-product-cart-btn remove-btn"><i class='bx bx-trash bx-flip-horizontal' ></i></a>
 */