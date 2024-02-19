@extends('layouts.main')
@section('title', 'Transaction Camera Page')

@section('main')
<x-search-bar></x-search-bar>

<div class="card">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Transaction Camera</h5>
    <a href="{{ route('bookings.cameras.create') }}" class="btn btn-primary me-3">Add Transaction</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>          
          <th>Code</th>
          <th>Total Price</th>
          <th>Total Payment</th>
          <th>Total Return</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($transactions as $item)        
          <tr class="table-body">
            <input type="hidden" class="transaction_id" value="{{ $item->id }}">
            <td>
              <span class="fw-medium">#{{ $item->code }}</span>
            </td>
            <td>
              <span class="fw-medium">Rp @rupiah($item->total_price)</span>
            </td>
            <td>
              <span class="fw-medium">Rp @rupiah($item->total_payment)</span>
            </td>
            <td>
              <span class="fw-medium">Rp @rupiah($item->total_return)</span>
            </td>                     
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('bookings.cameras.show', $item->id) }}"
                    ><i class="bx bx-file me-1"></i> Detail</a
                  >
                  <a class="dropdown-item delete-transaction-data" href="#" data-bs-toggle="modal"
                  data-bs-target="#deleteTransactionModal"
                    ><i class="bx bx-trash me-1"></i> Delete</a
                  >
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Transaction not found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="mx-3">
      {{ $transactions->links() }}
    </div>
  </div>
</div>

{{-- @include('partials.modal-transaction') --}}
@endsection

@push('js')
<script src="{{ asset('assets/js/custom/transaction.js') }}"></script>
@endpush