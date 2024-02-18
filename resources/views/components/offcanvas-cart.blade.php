<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
    aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasCartLabel" class="offcanvas-title">Your Cart (<span class="cart-count">0</span>)</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <div>
            <div id="{{ $name }}"></div>
            <div class="card checkout-container mt-2 mb-4">
                <form action="{{ $route }}" method="POST" class="card-body">
                  @csrf
                  <input type="hidden" name="total_price" id="total-price" required>
                  <input type="hidden" name="total_return" id="total-return" required>
                  <div class="mb-3">
                    <p class="card-text mb-1">Pay</p>
                    <input type="text" name="total_payment" required class="form-control total-pay-input" placeholder="Rp. 0,00">
                  </div>
                  <div class="d-flex justify-content-between mb-0">
                    <p class="card-text">Total</p>
                    <p class="card-text total-cart-count">Rp 0,00</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p class="card-text">Return</p>
                    <p class="card-text total-return-count">Rp 0,00</p>
                  </div>
                  <div class="d-block">
                    <button class="btn btn-primary checkout-btn" type="submit" style="width: 100%">Checkout</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
