@extends('layouts.main')
@section('title') Dashboard Analytics Page @endsection

@section('main')
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-3 col-sm-6 col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="/assets/img/icons/unicons/chart-success.png"
                  alt="chart success"
                  class="rounded" />
              </div>
            </div>
            <span class="fw-medium d-block mb-1">
              @if (auth()->user()->isAdmin())
                Total Staff
              @else
                Camera Rented
              @endif
            </span>
            <h3 class="card-title mb-2">
              @if (auth()->user()->isAdmin())
                  {{ $staff_count }}
              @else
                  {{ $camera_rented }}
              @endif
            </h3>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="/assets/img/icons/unicons/chart-success.png"
                  alt="chart success"
                  class="rounded" />
              </div>
            </div>
            <span class="fw-medium d-block mb-1">
              @if (auth()->user()->isAdmin())
                Total Customer
              @else
                Facility Rented
              @endif
            </span>
            <h3 class="card-title mb-2">
              @if (auth()->user()->isAdmin())
                  {{ $customer_count }}
              @else
                  {{ $facility_rented }}
              @endif
            </h3>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="/assets/img/icons/unicons/chart-success.png"
                  alt="chart success"
                  class="rounded" />
              </div>
            </div>
            <span class="fw-medium d-block mb-1">
              @if (auth()->user()->isAdmin())
                Total Transaction Rented
              @else
                Camera Returned
              @endif
            </span>
            <h3 class="card-title mb-2">
              @if (auth()->user()->isAdmin())
                  {{ $transaction_rented }}
              @else
                  {{ $camera_returned }}
              @endif
            </h3>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="/assets/img/icons/unicons/chart-success.png"
                  alt="chart success"
                  class="rounded" />
              </div>
            </div>
            <span class="fw-medium d-block mb-1">
              @if (auth()->user()->isAdmin())
                Total Transaction Returned
              @else
                Facility Returned
              @endif
            </span>
            <h3 class="card-title mb-2">
              @if (auth()->user()->isAdmin())
                {{ $transaction_returned }}
              @else
                {{ $facility_returned }}
              @endif
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Total Income -->
  <div class="col-12 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-12">
          <h5 class="card-header m-0 me-2 pb-3">Total Income</h5>
          <div id="chart1" class="px-2"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
    <script>
      let income_yearly = <?= json_encode($income_yearly); ?>;

      let options1 = {
			chart: {
				type: 'bar',
				height: 215
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: 26,
					endingShape: 'rounded',
					startingShape: 'rounded',
					rounded:'50%',
					borderRadius: 5,
					// borderRadiusApplication: 'end',
				},
			},
			colors:['#6562E8', '#7D7AFF'],

			series: [{
				name: 'Income',
				data: income_yearly
			}],
			xaxis: {
				categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul', 'Aug','Sep', 'Okt', 'Nov', 'Des']
			},
			yaxis: {
				categories: [10, 20, 30, 40, 50],
        labels: {
          formatter: function(value) {
            var val = Math.abs(value)
            if (val >= 1000) {
              // val = (val / 1000).toFixed(0) + ' K'
              val = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(val)
            }
            return val
          }
        }
			}
		}

    let chart = new ApexCharts(document.querySelector("#chart1"), options1);

		chart.render();
    </script>
@endpush