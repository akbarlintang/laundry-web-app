@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Daftar Pelanggan
      </h4>
    </div>
    <div class="col-4 text-right my-auto">
      <a href="javascript:;" onclick="app.tambah()" class="btn btn-md btn-primary" data-toggle="modal" data-target="#tambahModal">
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
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">No. HP</th>
            <th class="text-center">Alamat</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="store">
          <div class="modal-body">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" v-model="form.nama" placeholder="Masukkan nama pelanggan">
              </div>
              <div class="form-group">
                <label for="no_hp">No. Handphone</label>
                <input type="number" class="form-control" name="no_hp" id="no_hp" v-model="form.no_hp" placeholder="Masukkan nomor handphone pelanggan">
              </div>
              <div class="form-group">
                <label for="role">Alamat</label>
                <textarea name="alamat" id="alamat" v-model="form.alamat" class="form-control" rows="3" placeholder="Masukkan alamat pelanggan"></textarea>
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
          <h5 class="modal-title" id="exampleModalLabel">Edit Pelanggan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="update">
          <div class="modal-body">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" v-model="form.nama" placeholder="Masukkan nama pelanggan">
              </div>
              <div class="form-group">
                <label for="no_hp">No. Handphone</label>
                <input type="number" class="form-control" name="no_hp" id="no_hp" v-model="form.no_hp" placeholder="Masukkan nomor handphone pelanggan">
              </div>
              <div class="form-group">
                <label for="role">Alamat</label>
                <textarea name="alamat" id="alamat" v-model="form.alamat" class="form-control" rows="3" placeholder="Masukkan alamat pelanggan"></textarea>
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
        no_hp: '',
        alamat: ''
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
            url : "{{ route('pelanggan.datatable') }}",
            dataSrc: "data"
          },
          lengthMenu: [[10, 50, 100, 1000, -1], [10, 50, 100, 1000, "Semua"]],
          columns: [
            { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
            { data: 'nama' },
            { data: 'no_hp', className: 'text-center' },
            { data: 'alamat' },
            { data: 'aksi' },
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
        this.form.no_hp = data.no_hp;
        this.form.alamat = data.alamat;
        $('#editModal').modal('show');
      },
      delete(data){
        this.form.id = data.id;
        swal({
          title: 'Apakah anda yakin?',
          text: "Data pelanggan akan dihapus!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            axios.delete("{{ route('pelanggan.delete', ':id') }}".replace(':id', app.form.id))
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
          text: "Data pelanggan akan disimpan!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#tambahModal').modal('hide');
            axios.post("{{ route('pelanggan.store') }}", app.form)
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
          text: "Data pelanggan akan diubah!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            $('#editModal').modal('hide');
            axios.post("{{ route('pelanggan.update', ':id') }}".replace(':id', app.form.id), app.form)
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