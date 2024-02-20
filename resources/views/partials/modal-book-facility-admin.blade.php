<div class="modal fade" id="showFacilityModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showFacilityModalTitle">Add Item</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-4 mb-5">
                @foreach ($facilities as $item)
                    <div class="col facility-card detail-facility-data">
                        <input type="hidden" class="facility_id" value="{{ $item->id }}">
                        <div class="card w-full relative p-2">
                        <div class="position-absolute" style="top: 12px; left: 12px;">
                            <span class="badge bg-label-primary">{{ $item->facilityType->name }}</span>
                        </div>
                        <img class="card-img-top cursor-pointer" src="{{ asset("uploads/facilities/" . $item->facilityImages[0]->image) }}" alt="Card image cap" />
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