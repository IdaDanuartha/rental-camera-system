<div class="modal fade" id="showProductModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showProductModalTitle">Add Item</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-4 mb-5">
                @foreach ($products as $item)
                    <div class="col product-card detail-product-data">
                        <input type="hidden" class="product_id" value="{{ $item->id }}">
                        <div class="card w-full relative p-2">
                        <div class="position-absolute" style="top: 12px; left: 12px;">
                            <span class="badge bg-label-primary">{{ $item->deviceSeries->name }}</span>
                            <span class="badge bg-label-warning">{{ $item->deviceSeries->deviceBrand->deviceType->name }}</span>
                        </div>
                        @if (count($item->productImages))
                          <img class="card-img-top cursor-pointer" data-bs-toggle="modal" data-bs-target="#detailProductModal" src="{{ asset("uploads/products/" . $item->productImages[0]->image) }}" alt="Card image cap" />
                        @endif
                          <div class="card-body p-2 mt-4">
                              <h5 class="card-title">{{ $item->name }}</h5>
                              <p class="card-text">Rp. @rupiah($item->rental_price)/day</p>
                              <div class="block">
                                  <button class="btn btn-primary add-to-cart-btn" type="button" style="width: 100%">Add</button>
                              </div>
                          </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </form>
    </div>
  </div>