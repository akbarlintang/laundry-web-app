@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Daftar Transaksi
      </h4>
    </div>
    <div class="col-4 text-right my-auto">
      <a href="{{ route('transaksi.tambah') }}" class="btn btn-md btn-primary">
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
      Data transaksi baru berhasil disimpan!
    </div>
  @endif

  @if(session('update'))
    <div class="alert alert-success" role="alert">
      Data transaksi berhasil diubah!
    </div>
  @endif

  <div class="row no-gutters row-bordered row-border-light">
    <div class="table-responsive">
      <table id="datatable" class="table table-hoverable table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No.</th>
            <th class="text-center">No. Invoice</th>
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Tanggal Order</th>
            <th class="text-center">Tanggal Selesai</th>
            <th class="text-center">Paket</th>
            <th class="text-center">Berat</th>
            <th class="text-center">Total</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Pembayaran</th>
            <th class="text-center">Foto</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  
  {{-- Status modal --}}
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Status Pengerjaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="updateStatus">
          <div class="modal-body">
            <div class="form-group">
              <label for="role">Status Pengerjaan</label>
              <select name="status" id="status" class="form-control custom-select" v-model="form.status" required>
                <option value=""></option>
                <option v-for="stts in statusList" :value="stts.id">@{{ stts.nama }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success text-white">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End status modal --}}

  {{-- Pembayaran modal --}}
  <div class="modal fade" id="pembayaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Status Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="updatePembayaran">
          <div class="modal-body">
            <div class="form-group">
              <label for="role">Status Pembayaran</label>
              <select name="pembayaran" id="pembayaran" class="form-control custom-select" v-model="form.pembayaran" required>
                <option value=""></option>
                <option value="lunas">Lunas</option>
                <option value="belum-lunas">Belum Lunas</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success text-white">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End pembayaran modal --}}

  {{-- Galeri modal --}}
  <div class="modal fade" id="galeriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Galeri Transaksi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div v-for="(ft, index) in form.foto" class="mb-3">
            {{-- <h4>Foto @{{ index+1 }}</h4> --}}
            <img :src="'/storage/transaksi/' + ft" alt="foto barang" class="img-thumbnail">
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
        id: '',
        nama: '',
        status: '',
        pembayaran: '',
        foto: [],
      },
      statusList: @json($status),
    },
    mounted() {
      this.datatable();
      this.initStatusSelect();
      this.initPembayaranSelect();
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
            url : "{{ route('transaksi.datatable') }}",
            dataSrc: "data"
          },
          // "order": [[ 2, "desc" ]],
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
            { data: 'no_invoice', className: 'text-center' },
            { data: 'pelanggan' },
            { data: 'tgl_order', className: 'text-center' },
            { data: 'tgl_selesai', className: 'text-center' },
            { data: 'paket', className: 'text-center' },
            { data: 'berat', className: 'text-center' },
            { data: 'total', className: 'text-right' },
            { data: 'keterangan', className: 'text-center' },
            { data: 'status', className: 'text-center' },
            { data: 'pembayaran', className: 'text-center' },
            { data: 'foto', className: 'text-center' },
            { data: 'aksi', className: 'text-center' },
          ],
          "bDestroy": true
        });
      },
      initStatusSelect(){
        $('#status').val(this.form.status);
        $('#status').select2({
          placeholder: "Pilih status pengerjaan",
          width: "100%",
        }).on("change", function (e) { 
          app.form.status = $('#status').val();
        });
      },
      initPembayaranSelect(){
        $('#pembayaran').val(this.form.pembayaran);
        $('#pembayaran').select2({
          placeholder: "Pilih status pembayaran",
          width: "100%",
        }).on("change", function (e) { 
          app.form.pembayaran = $('#pembayaran').val();
        });
      },
      clear(){
        this.form.nama = '';
        this.form.status = '';
        this.form.foto = [];
      },
      status(data){
        // console.log(data.status);
        this.clear();
        this.form.id = data.id;
        this.form.status = data.status.status.id;
        this.initStatusSelect();
        $('#statusModal').modal('show');
      },
      pembayaran(data){
        this.clear();
        this.form.id = data.id;
        this.form.pembayaran = data.pembayaran;
        this.initPembayaranSelect();
        $('#pembayaranModal').modal('show');
      },
      galeri(data){
        this.clear();
        this.form.id = data.id;
        this.form.foto = data.foto;
        $('#galeriModal').modal('show');
      },
      updateStatus(){
        swal({
          title: 'Apakah anda yakin?',
          text: "Status pengerjaan akan diubah!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#statusModal').modal('hide');
            axios.post("{{ route('transaksi.updateStatus', ':id') }}".replace(':id', app.form.id), app.form)
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Status pengerjaan berhasil diubah!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Status pengerjaan gagal diubah!',
              })
            });
          }else if(result.dismiss == 'cancel'){

          }
        });
      },
      updatePembayaran(){
        swal({
          title: 'Apakah anda yakin?',
          text: "Status pembayaran akan diubah!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#pembayaranModal').modal('hide');
            axios.post("{{ route('transaksi.updatePembayaran', ':id') }}".replace(':id', app.form.id), app.form)
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Status pembayaran berhasil diubah!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Status pembayaran gagal diubah!',
              })
            });
          }else if(result.dismiss == 'cancel'){

          }
        });
      },
      delete(data){
        this.form.id = data.id;
        swal({
          title: 'Apakah anda yakin?',
          text: "Data akan dihapus!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            axios.delete("{{ route('transaksi.delete', ':id') }}".replace(':id', app.form.id))
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Data berhasil dihapus!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Data gagal dihapus!',
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