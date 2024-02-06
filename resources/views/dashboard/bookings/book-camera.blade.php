@extends('layouts.main')
@section('title', 'Booking Camera Page')

@section('main')
<x-search-bar>
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item relative cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <span class="rounded-circle bg-danger cart-count text-white position-absolute" style="right: 10px; top: 10px; padding: 1px 5px; font-size: 12px;">3</span>
            <button class="nav-link">
                <i class='bx bx-cart' style="font-size: 28px"></i>
            </button>
        </li>
        <!--/ User -->
    </ul>
</x-search-bar>
<x-offcanvas-cart></x-offcanvas-cart>

<div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-4 mb-5">
    @foreach ($products as $item)
        <div class="col product-card detail-product-data">
            <input type="hidden" class="product_id" value="{{ $item->id }}">
            <div class="card w-full relative p-2">
            <div class="position-absolute" style="top: 12px; left: 12px;">
                <span class="badge bg-label-primary">{{ $item->deviceSeries->name }}</span>
                <span class="badge bg-label-warning">{{ $item->deviceSeries->deviceBrand->deviceType->name }}</span>
            </div>
            <img class="card-img-top cursor-pointer" data-bs-toggle="modal" data-bs-target="#detailProductModal" src="{{ asset("uploads/products/" . $item->productImages[0]->image) }}" alt="Card image cap" />
            <div class="card-body p-2 mt-4">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="card-text">Rp. @rupiah($item->rental_price)/day</p>
                <div class="block">
                    <button class="btn btn-primary add-to-cart-btn" style="width: 100%">Add to Cart</button>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
@include('partials.modal-book-product')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/book-product.js') }}"></script>
@endpush