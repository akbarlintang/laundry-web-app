@extends('layout.master')

@push('plugin-styles')
  <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-cube text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Transaksi Keseluruhan</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ count($transaksi) }}</h3>
            </div>
          </div>
        </div>
        {{-- <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Transaksi Bulan Ini</p> --}}
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-receipt text-warning icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Transaksi Bulan Ini</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{ count($totalTransaksi) }}</h3>
            </div>
          </div>
        </div>
        {{-- <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales </p> --}}
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-poll-box text-success icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Pemasukan Bulan Ini</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">Rp {{ $pemasukan }}</h3>
            </div>
          </div>
        </div>
        {{-- <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales </p> --}}
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-cash-multiple text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Pengeluaran Bulan Ini</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">Rp {{ $pengeluaran }}</h3>
            </div>
          </div>
        </div>
        {{-- <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales </p> --}}
      </div>
    </div>
  </div>
</div>

{{-- Chart pemasukan --}}
<div class="row mb-3">
  <div class="col-md-12">
    <canvas id="line-chart" width="100%" height="30%"></canvas>
  </div>
</div>

{{-- Chart pengeluaran --}}
<div class="row">
  <div class="col-md-12">
    <canvas id="line-chart-keluar" width="100%" height="30%"></canvas>
  </div>
</div>
@endsection

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
  {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}

  <script>
    // Chart pemasukan
    new Chart(document.getElementById("line-chart"), {
      type: 'line',
      data: {
        labels: @json($label),
        datasets: [{ 
            data: @json($data),
            label: "Pemasukan",
            borderColor: "#00C851",
            fill: false
          }
        ]
      },
      options: {
        title: {
          display: true,
          text: 'Pemasukan bulanan'
        }
      }
    });
  // End chart pemasukan

  // Chart Pengeluaran
  new Chart(document.getElementById("line-chart-keluar"), {
    type: 'line',
    data: {
      labels: @json($label_klr),
      datasets: [{ 
          data: @json($data_klr),
          label: "Pengeluaran",
          borderColor: "#e91e63",
          fill: false
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Pengeluaran bulanan'
      }
    }
  });
  // End chart Pengeluaran
  </script>
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/dashboard.js') !!}
@endpush