<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
    aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasCartLabel" class="offcanvas-title">Your Cart (<span class="cart-count">0</span>)</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <div>
            <div id="product_carts"></div>
            <div class="card checkout-container mt-2 mb-4">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <p class="card-text">Total</p>
                    <p class="card-text total-cart-count">Rp 0,00</p>
                  </div>
                  <form action="{{ route('bookings.cameras.store') }}" method="POST" class="d-block">
                    @csrf
                    <button class="btn btn-primary checkout-btn" type="submit" style="width: 100%">Checkout</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
