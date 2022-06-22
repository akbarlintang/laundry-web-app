@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Edit Catatan Pengeluaran
      </h4>
    </div>
  </div>

  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}
    </div>
  @endforeach

  <form action="{{ route('pengeluaran.update', $data->id) }}" method="POST" id="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row no-gutters row-bordered row-border-light">
      <div class="col-8">
        <div class="form-group row">
          <label for="tgl" class="col-sm-3 col-form-label">Tanggal Pengeluaran</label>
          <div class="col-sm-9 input-group">
            <input type="text" class="form-control" name="tgl" id="tgl" v-model="form.tgl" placeholder="Tanggal pengeluaran" readonly required>
          </div>
        </div>
        <div class="form-group row">
          <label for="total" class="col-sm-3 col-form-label">Total Pengeluaran</label>
          <div class="col-sm-9 input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Rp</div>
            </div>
            <input type="number" class="form-control" name="total" id="total" v-model="form.total" placeholder="Masukkan total pengeluaran" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
          <div class="col-sm-9 input-group">
            <textarea type="number" class="form-control" name="keterangan" id="keterangan" v-model="form.keterangan" placeholder="Masukkan keterangan pengeluaran" required></textarea>
          </div>
        </div>

        {{-- Jika ada file --}}
        @if ($data->bukti)
          @foreach ($data->bukti as $index => $dt)
            <div class="form-group row">
              <label for="keterangan" class="col-sm-3 col-form-label">Bukti terupload {{ $index+1 }}</label>
              <div class="col-sm-9">
                <a href="{{ route('pengeluaran.download', [$data->id, $index]) }}" class="btn btn-sm btn-success">Download</a>
                <a href='javascript:;' onclick='app.delete({{ $index }})' class="btn btn-sm btn-danger">Hapus</a>
              </div>
            </div>
          @endforeach
        @endif
          
        <div v-for="(key, index) in form.file" :key="`formDok-${index}`">
          <div class="form-group m-form__group row">
            <label class="col-lg-3 col-form-label" for="foto">
              Upload Bukti @{{ index+1 }}
            </label>
            <div class="col-lg-7">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file[]">
                <label class="custom-file-label" for="customFile">Upload Bukti</label>
              </div>
            </div>
            <div class="col-lg-2 align-middle">
              <span class="btn btn-success btn-sm" @click="addField(key, form.file)">Tambah</span>
              <span class="btn btn-danger btn-sm" @click="removeField(index, form.file)" v-show="form.file.length > 1">Hapus</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-3">
      <button type="submit" class="btn btn-success text-white">Simpan</button>
    </div>
  </form>
@endsection

@section('custom-scripts')
<script type="text/javascript" defer>
  const app = new Vue({
    el: '#app',
    data: {
      pengeluaran: '',
      form: {
        tgl: '',
        keterangan: '',
        total: '',
        bukti: '',
        file: '',
      },
    },
    mounted() {
      this.pengeluaran = @json($data);
      this.form.id = this.pengeluaran.id;
      this.form.tgl = this.pengeluaran.tgl_pengeluaran;
      this.form.keterangan = this.pengeluaran.keterangan;
      this.form.total = this.pengeluaran.total;

      this.form.file = [{
        val: '',
      }];

      $("#tgl").datepicker({
        todayBtn: "linked",
        clearBtn: true,
        format: "dd MM yyyy",
        autoclose: true,
        todayHighlight: true
      }).on("change", function (e) { 
        app.form.tgl = $('#tgl').val();
      });

      $(document).on('submit', '[id^=form]', function (e) {
        e.preventDefault();
        var form = document.forms["form"];
        swal({
          title: "Apakah anda yakin?",
          text: "Data pengeluaran akan diubah!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        }).then(function(result){
          if(result.value){
            form.submit();
          }else if(result.dismiss == 'cancel'){

          }
        });

        return false;
      });
    },
    methods: {
      removeField(index, fieldType) {
        fieldType.splice(index, 1);
      },
      addField(value, fieldType) {
        fieldType.push({
            val: '',
        });
      },
      delete(index) {
        swal({
          title: "Anda yakin akan menghapus bukti ini ?",
          text: "Bukti akan dihapus dari list",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        })
        .then(function(result){
          if(result.value){
            axios.delete("{{ route('pengeluaran.file.delete', [':id', ':index']) }}".replace(':id', app.form.id).replace(':index', index))
              .then((response) => {
                swal({
                  type: 'success',
                  title: 'Sukses',
                  text: 'Bukti berhasil dihapus!',
                })
                .then(function(result){
                  location.reload();
                });
              })
              .catch((e) => {
                toastr.error('Terjadi kesalahan!')
              });
          }else if(result.dismiss == 'cancel'){

          }
        });
      },
    }
  });
</script>
@endsection