<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="text-wrapper">
            {{-- <h4 class="profile-name">Milla Laundry Logo</h4> --}}
            <img src="{{ asset('assets/landing/img/milla-laundry-logo.png') }}" class="w-75" alt="logo">
          </div>
        </div>
      </div>
    </li>
    <li class="nav-item {{ active_class(['admin/dashboard']) }}">
      <a class="nav-link" href="{{ route('dashboard.index') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    {{-- <li class="nav-item {{ active_class(['basic-ui/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['basic-ui/*']) }}" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-dna"></i>
        <span class="menu-title">Basic UI Elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['basic-ui/*']) }}" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['basic-ui/buttons']) }}">
            <a class="nav-link" href="{{ url('/basic-ui/buttons') }}">Buttons</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/dropdowns']) }}">
            <a class="nav-link" href="{{ url('/basic-ui/dropdowns') }}">Dropdowns</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/typography']) }}">
            <a class="nav-link" href="{{ url('/basic-ui/typography') }}">Typography</a>
          </li>
        </ul>
      </div>
    </li> --}}

    {{-- <li class="nav-item {{ active_class(['charts/chartjs']) }}">
      <a class="nav-link" href="{{ url('/charts/chartjs') }}">
        <i class="menu-icon mdi mdi-chart-line"></i>
        <span class="menu-title">Charts</span>
      </a>
    </li> --}}

    {{-- <li class="nav-item {{ active_class(['icons/material']) }}">
      <a class="nav-link" href="{{ url('/icons/material') }}">
        <i class="menu-icon mdi mdi-emoticon"></i>
        <span class="menu-title">Icons</span>
      </a>
    </li> --}}
    {{-- <li class="nav-item {{ active_class(['user-pages/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#user-pages" aria-expanded="{{ is_active_route(['user-pages/*']) }}" aria-controls="user-pages">
        <i class="menu-icon mdi mdi-lock-outline"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['user-pages/*']) }}" id="user-pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link" href="{{ url('/user-pages/login') }}">Login</a>
          </li>
          <li class="nav-item {{ active_class(['user-pages/register']) }}">
            <a class="nav-link" href="{{ url('/user-pages/register') }}">Register</a>
          </li>
          <li class="nav-item {{ active_class(['user-pages/lock-screen']) }}">
            <a class="nav-link" href="{{ url('/user-pages/lock-screen') }}">Lock Screen</a>
          </li>
        </ul>
      </div>
    </li> --}}
    {{-- <li class="nav-item">
      <a class="nav-link" href="https://www.bootstrapdash.com/demo/star-laravel-free/documentation/documentation.html" target="_blank">
        <i class="menu-icon mdi mdi-file-outline"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li> --}}

    <li class="nav-item {{ active_class(['admin/transaksi', 'admin/transaksi/*']) }}">
      <a class="nav-link" href="{{ route('transaksi.index') }}">
        <i class="menu-icon mdi mdi-shopping"></i>
        <span class="menu-title">Transaksi</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['admin/pelanggan']) }}">
      <a class="nav-link" href="{{ route('pelanggan.index') }}">
        <i class="menu-icon mdi mdi-account-box"></i>
        <span class="menu-title">Pelanggan</span>
      </a>
    </li>

    @if (auth()->user()->Role->id == 1 || auth()->user()->Role->nama == 'Admin')
      <li class="nav-item {{ active_class(['admin/master/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="{{ is_active_route(['admin/master/*']) }}" aria-controls="akun">
          <i class="menu-icon mdi mdi-lock-outline"></i>
          <span class="menu-title">Master</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ show_class(['admin/master/*']) }}" id="master">
          <ul class="nav flex-column sub-menu">

            <li class="nav-item {{ active_class(['admin/master/pemasukan']) }}">
              <a class="nav-link" href="{{ route('pemasukan.index') }}">Pemasukan</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/pengeluaran']) }}">
              <a class="nav-link" href="{{ route('pengeluaran.index') }}">Pengeluaran</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/karyawan']) }}">
              <a class="nav-link" href="{{ route('karyawan.index') }}">Karyawan</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/role']) }}">
              <a class="nav-link" href="{{ route('role.index') }}">Role</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/paket']) }}">
              <a class="nav-link" href="{{ route('paket.index') }}">Paket</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/status']) }}">
              <a class="nav-link" href="{{ route('status.index') }}">Status</a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/config']) }}">
              <a class="nav-link" href="{{ route('config.index') }}">Landing Page</a>
            </li>
          </ul>
        </div>
      </li>
    @endif


    <li class="nav-item {{ active_class(['admin/akun/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#akun" aria-expanded="{{ is_active_route(['akun/*']) }}" aria-controls="akun">
        <i class="menu-icon mdi mdi-account-settings"></i>
        <span class="menu-title">Akun</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['admin/akun/*']) }}" id="akun">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['admin/akun/pengaturan']) }}">
            <a class="nav-link" href="{{ route('pengaturan.index') }}">Pengaturan</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>