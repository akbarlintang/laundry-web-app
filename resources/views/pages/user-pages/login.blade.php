@extends('layout.master-mini')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">
      <div class="auto-form-wrapper py-5">

        {{-- Jika ada error saat login --}}
        @if (session()->has('errors'))
          <div class="alert alert-danger">
            {{ session('errors')->first('salah') }}
          </div>
        @endif

        {{-- Jika user telah logout --}}
        @if(session('logout'))
          <div class="alert alert-danger" role="alert">
            Akun anda telah berhasil logout!
          </div>
        @endif

        <form method="POST" action="{{ route('login.custom') }}">
          {{ csrf_field() }}
          {{-- <div class="text-center my-5">
            <img src="{{ asset('assets/landing/img/milla-laundry-logo.png') }}" class="w-25" alt="logo">
          </div> --}}
          <div class="form-group">
            <label class="label">Username</label>
            <div class="input-group">
              <input type="text" class="form-control" name="username" placeholder="Username" required>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" placeholder="*********" required>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block">Login</button>
          </div>
          {{-- <div class="form-group d-flex justify-content-between">
            <div class="form-check form-check-flat mt-0">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" checked> Keep me signed in </label>
            </div>
            <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
          </div>
          <div class="form-group">
            <button class="btn btn-block g-login">
              <img class="mr-3" src="{{ url('assets/images/file-icons/icon-google.svg') }}" alt="">Log in with Google</button>
          </div>
          <div class="text-block text-center my-3">
            <span class="text-small font-weight-semibold">Not a member ?</span>
            <a href="{{ url('/user-pages/register') }}" class="text-black text-small">Create new account</a>
          </div> --}}
        </form>
      </div>
      {{-- <ul class="auth-footer">
        <li>
          <a href="#">Conditions</a>
        </li>
        <li>
          <a href="#">Help</a>
        </li>
        <li>
          <a href="#">Terms</a>
        </li>
      </ul> --}}
      <p class="footer-text text-center mt-5">Copyright ?? 2022 Milla Laundry & Dry Cleaning. All rights reserved.</p>
    </div>
  </div>
</div>

@endsection