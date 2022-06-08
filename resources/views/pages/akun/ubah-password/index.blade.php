@extends('layout.master')

@section('breadcrumb')
  <nav aria-label="breadcrumb" class="bg-white">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Beranda</a></li>
      <li class="breadcrumb-item"><a href="#">Akun</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
    </ol>
  </nav>
@endsection

@section('content')

  <h4 class="font-weight-bold py-3 mb-4">
    Pengaturan Akun
  </h4>

  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}
    </div>
  @endforeach

  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Ubah password</a>
        {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a> --}}
      </div>
    </div>

    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade active show" id="account-general">
          <div class="container">
            <form method="POST" action="{{ route('pengaturan.general.update') }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control mb-1" value="{{ auth()->user()->username }}">
              </div>
              <div class="form-group">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ auth()->user()->nama }}">
              </div>
              <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="text" name="email" class="form-control mb-1" value="{{ auth()->user()->email }}">
              </div>
              <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ auth()->user()->no_hp }}">
              </div>
              <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control">{{ auth()->user()->alamat }}</textarea>
              </div>

              <div class="text-right">
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
          </div>
        </div>

        <div class="tab-pane fade" id="account-change-password">
          <div class="container">
            <div class="form-group">
              <label class="form-label">Password lama</label>
              <input type="password" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label">Password baru</label>
              <input type="password" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label">Ulangi password</label>
              <input type="password" class="form-control">
            </div>
          </div>
        </div>

        {{-- <div class="tab-pane fade" id="account-info">
          <div class="card-body pb-2">
            <div class="form-group">
              <label class="form-label">Bio</label>
              <textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
            </div>
            <div class="form-group">
              <label class="form-label">Birthday</label>
              <input type="text" class="form-control" value="May 3, 1995">
            </div>
            <div class="form-group">
              <label class="form-label">Country</label>
              <select class="custom-select">
                <option>USA</option>
                <option selected="">Canada</option>
                <option>UK</option>
                <option>Germany</option>
                <option>France</option>
              </select>
            </div>
          </div>
          <hr class="border-light m-0">
          <div class="card-body pb-2">

            <h6 class="mb-4">Contacts</h6>
            <div class="form-group">
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" value="+0 (123) 456 7891">
            </div>
            <div class="form-group">
              <label class="form-label">Website</label>
              <input type="text" class="form-control" value="">
            </div>

          </div>
  
        </div> --}}
      </div>
    </div>
  </div>

@endsection

@section('custom-scripts')
<script>
  export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
@endsection