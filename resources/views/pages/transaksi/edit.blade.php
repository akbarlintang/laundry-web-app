@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row">
    <div class="col-8">
      <h4 class="font-weight-bold py-3 mb-4">
        Edit Transaksi
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

  <form action="{{ route('transaksi.update', $data->id) }}" method="POST" id="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row no-gutters row-bordered row-border-light">
      <div class="col-8">
        <div class="form-group row">
          <label for="invoice" class="col-sm-3 col-form-label">No. Invoice</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="invoice" id="invoice" v-model="form.invoice" placeholder="Invoice transaksi" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="tgl_order" class="col-sm-3 col-form-label">Tanggal Transaksi</label>
          <div class="col-sm-9 input-group">
            <input type="text" class="form-control" name="tgl_order" id="tgl_order" v-model="form.tgl_order" placeholder="Tanggal order" readonly>
            <span class="mx-3 my-auto">s/d</span>
            <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" v-model="form.tgl_selesai" placeholder="Tanggal estimasi selesai" required readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="pelanggan_id" class="col-sm-3 col-form-label">Pelanggan</label>
          <div class="col-sm-9">
            <select name="pelanggan_id" id="pelanggan_id" class="form-control custom-select" v-model="form.pelanggan_id" required>
              <option value="" disabled hidden selected>Pilih pelanggan</option>
              <option v-for="pel in pelanggan" :value="pel.id">@{{ pel.nama }}</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="paket_id" class="col-sm-3 col-form-label">Paket</label>
          <div class="col-sm-9">
            <select name="paket_id" id="paket_id" class="form-control custom-select" v-model="form.paket_id" required>
              <option value=""></option>
              <option v-for="pak in paket" :value="pak.id">@{{ pak.nama }}</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="berat" class="col-sm-3 col-form-label">Berat</label>
          <div class="col-sm-9 input-group">
            <input type="number" class="form-control" name="berat" id="berat" v-model="form.berat" placeholder="Masukkan total berat transaksi" required>
            <div class="input-group-prepend">
              <div class="input-group-text">Kg</div>
            </div>
          </div>
        </div>

        {{-- Jika ada file --}}
        @if ($data->foto)
          @foreach ($data->foto as $index => $dt)
            <div class="form-group row">
              <label for="keterangan" class="col-sm-3 col-form-label">Foto terupload {{ $index+1 }}</label>
              <div class="col-sm-9">
                <a href="{{ route('transaksi.download', [$data->id, $index]) }}" class="btn btn-sm btn-success">Download</a>
                <a href='javascript:;' onclick='app.delete({{ $index }})' class="btn btn-sm btn-danger">Hapus</a>
              </div>
            </div>
          @endforeach
        @endif

        <div v-for="(key, index) in form.file" :key="`formDok-${index}`">
          <div class="form-group m-form__group row">
            <label class="col-lg-3 col-form-label" for="foto">
              Upload Foto @{{ index+1 }}
            </label>
            <div class="col-lg-7">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file[]">
                <label class="custom-file-label" for="customFile">Upload foto</label>
              </div>
            </div>
            <div class="col-lg-2 align-middle">
              <span class="btn btn-success btn-sm" @click="addField(key, form.file)">Tambah</span>
              <span class="btn btn-danger btn-sm" @click="removeField(index, form.file)" v-show="form.file.length > 1">Hapus</span>
            </div>
          </div>
        </div>

        <div class="form-group row mt-5">
          <div class="col-sm-5 text-left">
            <div>
              <label for="total" class="col-form-label">Total Harga</label>
              <input type="hidden" class="form-control" name="total" id="total" v-model="form.total" placeholder="Masukkan total harga transaksi" readonly>
            </div>
            <div>
              <h3>Rp @{{ (form.total).toLocaleString('en-US') }}<h3>
            </div>
          </div>
          <div class="col-sm-7"></div>
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
      transaksi: '',
      form: {
        id: '',
        invoice: '',
        tgl_order: '',
        tgl_selesai: '',
        pelanggan_id: '',
        paket_id: '',
        paket_harga: '',
        berat: '',
        total: 0,
        file: '',
      },
      pelanggan: @json($pelanggan),
      paket: @json($paket)
    },
    mounted() {
      var today = new Date();
      var date = today.getDate();
      var lastId = '{{ $last_id }}';

      this.transaksi = @json($data);
      this.form.id = this.transaksi.id;
      this.form.invoice = this.transaksi.no_invoice;
      this.form.tgl_order = this.transaksi.tgl_order;
      this.form.tgl_selesai = this.transaksi.tgl_selesai;
      this.form.pelanggan_id = this.transaksi.pelanggan_id;
      this.form.paket_id = this.transaksi.paket_id;
      this.form.berat = this.transaksi.berat;
      this.form.total = this.transaksi.total;

      this.form.file = [{
        val: '',
      }];

      $('#pelanggan_id').val(this.form.pelanggan_id);
      $('#pelanggan_id').select2({
        placeholder: "Pilih pelanggan",
        width: "100%",
      }).on("change", function (e) { 
        app.form.pelanggan_id = $('#pelanggan_id').val();
      });

      $('#paket_id').val(this.form.paket_id);
      $('#paket_id').select2({
        placeholder: "Pilih paket",
        width: "100%",
      }).on("change", function (e) { 
        app.getPaket();
      });

      $('#berat').on("input", function (e) {
        app.getPaket();
        app.hitung();
      });

      $("#tgl_selesai").datepicker({
          todayBtn: "linked",
          clearBtn: true,
          format: "dd MM yyyy",
          todayHighlight: true
      }).on("change", function (e) { 
        app.form.tgl_selesai = $('#tgl_selesai').val();
      });

      $(document).on('submit', '[id^=form]', function (e) {
        e.preventDefault();
        var form = document.forms["form"];
        swal({
          title: "Apakah anda yakin?",
          text: "Data transaksi akan diubah!",
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
      getPaket(){
        app.form.paket_id = $('#paket_id').val();
        axios.get("{{ route('paket.get', ':id') }}".replace(':id', app.form.paket_id))
            .then((response) => {
              app.form.paket_harga = response.data.harga;
              app.hitung();
            })
            .catch((e) => {
              toastr.error('Terdapat kesalahan!');
            });
      },
      hitung(){
        app.form.total = app.form.paket_harga * app.form.berat;
      },
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
          title: "Anda yakin akan menghapus foto ini ?",
          text: "Foto akan dihapus dari list",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#ff4444',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
        })
        .then(function(result){
          if(result.value){
            axios.delete("{{ route('transaksi.file.delete', [':id', ':index']) }}".replace(':id', app.form.id).replace(':index', index))
              .then((response) => {
                swal({
                  type: 'success',
                  title: 'Sukses',
                  text: 'Foto berhasil dihapus!',
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