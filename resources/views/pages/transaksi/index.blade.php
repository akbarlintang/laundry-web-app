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

  <div class="row no-gutters row-bordered row-border-light">
    <div class="table-responsive">
      <table id="datatable" class="table table-hoverable table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No. Invoice</th>
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Tanggal Order</th>
            <th class="text-center">Tanggal Selesai</th>
            <th class="text-center">Paket</th>
            <th class="text-center">Berat</th>
            <th class="text-center">Total</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  {{-- Tambah modal --}}
  <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="store">
          <div class="modal-body">
              <div class="form-group">
                <label for="role">Nama Role</label>
                <input type="text" class="form-control" name="role" id="role" v-model="form.nama" placeholder="Masukkan nama role">
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
  {{-- End tambah modal --}}

  {{-- Edit modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="update">
          <div class="modal-body">
              <div class="form-group">
                <label for="role">Nama Role</label>
                <input type="text" class="form-control" name="role" id="role" v-model="form.nama" placeholder="Masukkan nama role" required>
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
  {{-- End edit modal --}}
@endsection

@section('custom-scripts')
<script type="text/javascript" defer>
  const app = new Vue({
    el: '#app',
    data: {
      form: {
        id: '',
        nama: '',
      },
    },
    mounted() {
      this.datatable();
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
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'no_invoice', className: 'text-center' },
            { data: 'pelanggan' },
            { data: 'tgl_order', className: 'text-center' },
            { data: 'tgl_selesai', className: 'text-center' },
            { data: 'paket', className: 'text-center' },
            { data: 'berat', className: 'text-center' },
            { data: 'total', className: 'text-right' },
            { data: 'status', className: 'text-center' },
            { data: 'aksi', className: 'text-center' },
          ],
          "bDestroy": true
        });
      },
      clear(){
        this.form.nama = '';
        this.form.no_hp = '';
        this.form.alamat = '';
      },
      tambah(){
        this.clear();
        $('#tambahModal').modal('show');
      },
      edit(data){
        this.clear();
        this.form.id = data.id;
        this.form.nama = data.nama;
        $('#editModal').modal('show');
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
      store(){
        swal({
          title: 'Apakah anda yakin?',
          text: "Data akan disimpan!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#tambahModal').modal('hide');
            axios.post("{{ route('role.store') }}", app.form)
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Data berhasil disimpan!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Data gagal disimpan!',
              })
            });
          }else if(result.dismiss == 'cancel'){

          }
        });
      },
      update(id){
        swal({
          title: 'Apakah anda yakin?',
          text: "Data akan diubah!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#editModal').modal('hide');
            axios.post("{{ route('role.update', ':id') }}".replace(':id', app.form.id), app.form)
            .then((response) => {
              swal({
                type: 'success',
                title: 'Sukses',
                text: 'Data berhasil diubah!',
              });
              app.datatable();
            })
            .catch((e) => {
              swal({
                type: 'error',
                title: 'Error',
                text: 'Data gagal diubah!',
              })
            });
          }else if(result.dismiss == 'cancel'){

          }
        });
      }
    }
  });
</script>
@endsection