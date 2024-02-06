{{-- Detail Product --}}
<div class="modal fade" id="detailProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form class="modal-content">      
        <div class="modal-header">
          <h5 class="modal-title" id="detailProductModalTitle">Detail Product</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-12 mb-3">
                <div class="swiper produtImage" id="detail_product_images">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <img class="rounded" src="https://picsum.photos/200" width="100%" alt="">
                      </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                   {{-- @foreach ($product->productImages as $image)
                      <img src="{{ asset('uploads/products/' . $image->image) }}" class="border" width="200px" alt="">
                    @endforeach --}}
              </div>
            <div class="col-6 mb-3">
                <h4 class="card-text" id="detail_name">Judul</h4>
                <p class="card-text">Stock : <span id="detail_stock">0</span></p>
                <p class="card-text">Price : <span id="detail_rental_price">Rp 0.000</span>/day</p>
                <div class="pt-3 border-top">
                    <h6 class="mb-2">Description</h6>
                    <p id="detail_description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint delectus maxime reiciendis inventore eaque harum laudantium ipsam placeat cum dolorem.</p>
                </div>
              </div>
          </div>        
        </div>
      </form>
    </div>
  </div>