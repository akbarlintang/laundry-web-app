@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Rekap Pengeluaran
      </h4>
    </div>
    <div class="col-4 text-right my-auto">
      <a href="{{ route('pengeluaran.export') }}" class="btn btn-md btn-success" target="_blank">
        <i class="mdi mdi-file-excel"></i> Export
      </a>
      <a href="{{ route('pengeluaran.tambah') }}" class="btn btn-md btn-primary">
        <i class="mdi mdi-plus"></i> Tambah
      </a>
    </div>
  </div>

  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}
    </div>
  @endforeach

  @if(session('store'))
    <div class="alert alert-success" role="alert">
      Data pengeluaran baru berhasil disimpan!
    </div>
  @endif

  @if(session('update'))
    <div class="alert alert-success" role="alert">
      Data pengeluaran berhasil diubah!
    </div>
  @endif

  <div>
    <form @submit.prevent="filter" class="row">
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_mulai" class="col-sm-4 col-form-label">Tanggal Mulai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" placeholder="Pilih tanggal mulai" readonly>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group row">
          <label for="tgl_selesai" class="col-sm-4 col-form-label">Tanggal Selesai</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Pilih tanggal selesai" readonly>
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
            <th class="text-center">Tanggal</th>
            <th class="text-center">Total</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Bukti</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <div class="mt-5 mb-3 text-right">
    <div class="text-right">
      <h4>TOTAL PENGELUARAN</h4>
      <h3>Rp @{{ total }}</h3>
    </div>
  </div>

  {{-- Galeri modal --}}
  <div class="modal fade" id="galeriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Galeri Pengeluaran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div v-for="(bkt, index) in form.bukti" class="mb-3">
            {{-- <h4>Foto @{{ index+1 }}</h4> --}}
            <img :src="'/storage/pengeluaran/' + bkt" alt="bukti pengeluaran" class="img-thumbnail">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
    </div>
  </div>
  {{-- End galeri modal --}}
@endsection

@section('custom-scripts')
<script type="text/javascript" defer>
  const app = new Vue({
    el: '#app',
    data: {
      form: {
        tgl_mulai: '',
        tgl_selesai: '',
        bukti: [],
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
            url : "{{ route('pengeluaran.datatable') }}",
            dataSrc: "data"
          },
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
            { data: 'tgl', className: 'text-center' },
            { data: 'total', className: 'text-center' },
            { data: 'keterangan', className: 'text-left' },
            { data: 'bukti', className: 'text-center' },
            { data: 'aksi', className: 'text-center' },
          ],
          "bDestroy": true
        });
      },
      filter(){
        axios.post("{{ route('pengeluaran.filter') }}", app.form)
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
        axios.get("{{ route('pengeluaran.total') }}")
        .then((response) => {
          app.total = response.data;
        })
        .catch((e) => {
          console.log(e);
        });
      },
      clear(){
        this.form.bukti = [];
      },
      galeri(data){
        this.clear();
        this.form.id = data.id;
        this.form.bukti = data.bukti;
        $('#galeriModal').modal('show');
      },
      delete(data){
        this.form.id = data.id;
        swal({
          title: 'Apakah anda yakin?',
          text: "Data pengeluaran akan dihapus!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            axios.delete("{{ route('pengeluaran.delete', ':id') }}".replace(':id', app.form.id))
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Data pengeluaran berhasil dihapus!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Data pengeluaran gagal dihapus!',
              })
            });
          }else if(result.dismiss == 'cancel'){

          }
        });
      },
    }
  });
</script>
@endsection