@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Laporan Keuangan</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Laporan Keuangan
      </h4>
    </div>
    {{-- <div class="col-4 text-right my-auto">
      <a href="javascript:;" onclick="app.tambah()" class="btn btn-md btn-primary" data-toggle="modal" data-target="#tambahModal">
        <i class="mdi mdi-plus"></i> Tambah
      </a>
    </div> --}}
  </div>

  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}
    </div>
  @endforeach

  <div>
    <form action="{{ route('laporan-keuangan.filter') }}" method="POST" id="form" class="row">
      {{ csrf_field() }}
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_mulai" class="col-sm-4 col-form-label">Tanggal Mulai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" placeholder="Pilih tanggal mulai" value="{{ $laporan_mulai }}" readonly>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_selesai" class="col-sm-4 col-form-label">Tanggal Selesai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Pilih tanggal selesai" value="{{ $laporan_selesai }}" readonly>
          </div>
        </div>
      </div>
      <div class="col-2">
        <button type="submit" class="btn btn-success">Filter</button>
      </div>
    </form>
  </div>

  {{-- <div class="row no-gutters row-bordered row-border-light">
    <div class="table-responsive">
      <table id="datatable" class="table table-hoverable table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Pemasukan</th>
            <th class="text-center">Pengeluaran</th>
            <th class="text-center">Total</th>
          </tr>
        </thead>
      </table>
    </div>
  </div> --}}

  <div class="row no-gutters row-bordered row-border-light">
    {{-- <div class="table-responsive"> --}}
      <table class="table table-hoverable table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Pemasukan</th>
            <th class="text-center">Pengeluaran</th>
            <th class="text-center">Keuntungan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($query as $key => $item)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td class="text-center">{{ date('d F Y', strtotime($item['tgl'])) }}</td>
              <td class="text-right">Rp {{ isset($item['masuk']) ? number_format($item['masuk']) : '0'  }}</td>
              <td class="text-right">Rp {{ isset($item['keluar']) ? number_format($item['keluar']) : '0'  }}</td>

              @php
                $total = 0;
                if(isset($item['masuk']) && isset($item['keluar'])){
                  $total += ($item['masuk'] - $item['keluar']);
                } elseif (isset($item['masuk'])) {
                  $total += $item['masuk'];
                } elseif (isset($item['keluar'])) {
                  $total -= $item['keluar'];
                }
              @endphp
              <td class="text-right">{{ $total < 0 ? '-' : '+' }} Rp {{ number_format(abs($total)) }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="2" class="text-center font-weight-bold">TOTAL</td>
            <td class="text-right font-weight-bold">Rp {{ number_format($total_masuk) }}</td>
            <td class="text-right font-weight-bold">Rp {{ number_format($total_keluar) }}</td>
            <td class="text-right font-weight-bold">Rp {{ number_format($total_untung) }}</td>
          </tr>
        </tbody>
      </table>
    {{-- </div> --}}
  </div>

  {{-- <div class="mt-5 mb-3 text-right">
    <div class="text-right">
      <h4>TOTAL PEMASUKAN</h4>
      <h3>Rp @{{ total }}</h3>
    </div>
  </div> --}}
@endsection

@section('custom-scripts')
<script type="text/javascript" defer>
  const app = new Vue({
    el: '#app',
    data: {
      form: {
        tgl_mulai: '',
        tgl_selesai: ''
      },
      total: 0,
    },
    mounted() {
      // this.datatable();

      $("#tgl_mulai").datepicker({
          todayBtn: "linked",
          clearBtn: true,
          format: "dd MM yyyy",
          autoclose: true,
          todayHighlight: true
      }).on("change", function (e) { 
        app.form.tgl_mulai = $('#tgl_mulai').val();
      });

      $("#tgl_selesai").datepicker({
          todayBtn: "linked",
          clearBtn: true,
          format: "dd MM yyyy",
          autoclose: true,
          todayHighlight: true
      }).on("change", function (e) { 
        app.form.tgl_selesai = $('#tgl_selesai').val();
      });
    },
    methods: {
      datatable(){
        $('#datatable').DataTable({
          // processing: true,
          serverSide: true,
          dom: 'frtp',
          // buttons: {
          //   buttons: ['print', 'copyHtml5', 'csvHtml5', 'pdfHtml5', 'excelHtml5']
          // },
          ajax: {
            url : "{{ route('laporan-keuangan.datatable') }}",
            dataSrc: "data"
          },
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
            { data: 'tgl', className: 'text-center' },
            { data: 'pemasukan', className: 'text-center' },
            { data: 'pengeluaran', className: 'text-center' },
            { data: 'total', className: 'text-right' },
          ],
          "bDestroy": true
        });
      },
      filter(){
        axios.post("{{ route('laporan-keuangan.filter') }}", app.form)
        .then((response) => {
          location.replace();
          // toastr.success('Data berhasil ditampilkan!');
          // app.datatable();
        })
        .catch((e) => {
          toastr.error('Terdapat kesalahan!');
        });
      },
    }
  });
</script>
@endsection