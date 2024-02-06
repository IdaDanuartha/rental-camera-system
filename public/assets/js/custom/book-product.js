$(document).ready(function() {  
  $(".detail-product-data").on("click", function() {   
    $.ajax({
        type: "GET",
        url: `/products/${$(this).closest('.product-card').find('.product_id').val()}/json`,              
        dataType: "json",
        success: function({product}){   
          console.log(product)           
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
})

let swiper = new Swiper(".produtImage", {
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});