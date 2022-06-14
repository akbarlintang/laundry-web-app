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
        Buat Transaksi
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

  <form @submit.prevent="store">
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
            <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" v-model="form.tgl_selesai" placeholder="Tanggal estimasi selesai">
          </div>
        </div>
        <div class="form-group row">
          <label for="pelanggan_id" class="col-sm-3 col-form-label">Pelanggan</label>
          <div class="col-sm-9">
            <select name="pelanggan_id" id="pelanggan_id" class="form-control custom-select" v-model="form.pelanggan_id">
              <option value="" disabled hidden selected>Pilih pelanggan</option>
              <option v-for="pel in pelanggan" :value="pel.id">@{{ pel.nama }}</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="paket_id" class="col-sm-3 col-form-label">Paket</label>
          <div class="col-sm-9">
            <select name="paket_id" id="paket_id" class="form-control custom-select" v-model="form.paket_id">
              <option value=""></option>
              <option v-for="pak in paket" :value="pak.id">@{{ pak.nama }}</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="berat" class="col-sm-3 col-form-label">Berat</label>
          <div class="col-sm-9 input-group">
            <input type="number" class="form-control" name="berat" id="berat" v-model="form.berat" placeholder="Masukkan total berat transaksi">
            <div class="input-group-prepend">
              <div class="input-group-text">Kg</div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="total" class="col-sm-3 col-form-label">Total Harga</label>
          <div class="col-sm-9 input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Rp</div>
            </div>
            <input type="text" class="form-control" name="total" id="total" v-model="form.total" placeholder="Masukkan total harga transaksi" readonly>
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
      form: {
        id: '',
        invoice: '',
        tgl_order: '',
        pelanggan_id: '',
        paket_id: '',
        paket_harga: '',
        berat: '',
        total: 0,
      },
      pelanggan: @json($pelanggan),
      paket: @json($paket)
    },
    mounted() {
      $('#paket_id').select2({
        placeholder: "Pilih paket",
        width: "100%",
      }).on("change", function (e) { 
        app.getPaket();
      });

      $('#berat').on("input", function (e) {
        app.hitung();
      })

      $("#tgl_selesai").datepicker({
          todayBtn: "linked",
          clearBtn: true,
          format: "dd MM yyyy",
          todayHighlight: true
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
        app.form.total = (app.form.paket_harga * app.form.berat).toLocaleString('en-US');
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
    }
  });
</script>
@endsection