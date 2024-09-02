@extends('layouts.main')
@section('title', 'Booking Facility Page')

@section('main')
<x-search-bar>
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item relative cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <span class="rounded-circle bg-danger cart-count text-white position-absolute" style="right: 10px; top: 10px; padding: 1px 5px; font-size: 12px;">0</span>
            <button class="nav-link">
                <i class='bx bx-cart' style="font-size: 28px"></i>
            </button>
        </li>
        <!--/ User -->
    </ul>
</x-search-bar>
<x-offcanvas-cart>
    @slot('name')
        facility_carts
    @endslot
    @slot('route')
        /booking/facilities
    @endslot
</x-offcanvas-cart>

<div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 g-4 mb-5">
    @foreach ($facilities as $item)
        <div class="col facility-card detail-facility-data">
            <input type="hidden" class="facility_id" value="{{ $item->id }}">
            <div class="card w-full relative p-2">
            <div class="position-absolute" style="top: 12px; left: 12px;">
                <span class="badge bg-label-primary">{{ $item->facilityType->name }}</span>
            </div>
            @if (count($item->facilityImages))
            <img class="card-img-top cursor-pointer" data-bs-toggle="modal" data-bs-target="#detailFacilityModal" src="{{ asset("uploads/facilities/" . $item->facilityImages[0]->image) }}" alt="Card image cap" />
            @endif
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
@include('partials.modal-book-facility')
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/book-facility.js') }}"></script>
@endpush