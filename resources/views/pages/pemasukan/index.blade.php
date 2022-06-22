@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pemasukan</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Rekap Pemasukan
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
    <form @submit.prevent="filter" class="row">
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_mulai" class="col-sm-4 col-form-label">Tanggal Mulai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" placeholder="Pilih tanggal mulai" value="{{ $pemasukan_mulai }}" readonly>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_selesai" class="col-sm-4 col-form-label">Tanggal Selesai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Pilih tanggal selesai" value="{{ $pemasukan_selesai }}" readonly>
          </div>
        </div>
      </div>
      <div class="col-2">
        <button type="submit" class="btn btn-success">Filter</button>
      </div>
    </form>
  </div>

  <div class="row no-gutters row-bordered row-border-light">
    <div class="table-responsive">
      <table id="datatable" class="table table-hoverable table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Invoice</th>
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Tanggal Order</th>
            <th class="text-center">Paket</th>
            <th class="text-center">Berat</th>
            <th class="text-center">Total</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <div class="mt-5 mb-3 text-right">
    <div class="text-right">
      <h4>TOTAL PEMASUKAN</h4>
      <h3>Rp @{{ total }}</h3>
    </div>
  </div>
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
      this.datatable();
      this.totalGet();

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
            url : "{{ route('pemasukan.datatable') }}",
            dataSrc: "data"
          },
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
            { data: 'no_invoice', className: 'text-center' },
            { data: 'pelanggan' },
            { data: 'tgl_order', className: 'text-center' },
            { data: 'paket', className: 'text-center' },
            { data: 'berat', className: 'text-center' },
            { data: 'total', className: 'text-right' },
          ],
          "bDestroy": true
        });
      },
      filter(){
        axios.post("{{ route('pemasukan.filter') }}", app.form)
        .then((response) => {
          toastr.success('Data berhasil ditampilkan!');
          app.datatable();
          app.totalGet();
        })
        .catch((e) => {
          toastr.error('Terdapat kesalahan!');
        });
      },
      totalGet(){
        axios.get("{{ route('pemasukan.total') }}")
        .then((response) => {
          app.total = response.data;
        })
        .catch((e) => {
          console.log(e);
        });
      }
    }
  });
</script>
@endsection