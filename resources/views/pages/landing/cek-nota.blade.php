<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Milla Laundry & Dry Cleaning</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('assets/landing/img/milla-laundry-logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/landing/img/apple-touch-icon.png') }}">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/aos/aos.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/remixicon/remixicon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/step.css') }}">

  <!-- =======================================================
  * Template Name: FlexStart - v1.9.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        {{-- <img src="{{ asset('assets/landing/img/logo.png') }}" alt="logo"> --}}
        <img src="{{ asset('assets/landing/img/milla-laundry-logo.png') }}" alt="logo">
        {{-- <span>Milla Laundry</span> --}}
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          {{-- <li><a class="nav-link scrollto" href="#content">Cek Resi</a></li> --}}
          <li><a class="getstarted scrollto" href="#content">Cek Invoice</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-4 text-center">
          {{-- <img src="{{ asset('assets/landing/img/hero-img.png') }}" class="img-fluid" alt=""> --}}
          {{-- <link rel="icon" href="{{ asset('assets/landing/img/milla-laundry-logo.png') }}"> --}}
          <img src="{{ asset('assets/landing/img/milla-laundry-logo.png') }}" class="img-fluid w-50" alt="logo">
        </div>
        <div class="col-lg-8 d-flex flex-column justify-content-center px-5">
          <h1>{{ $config->where('key', 'hero-title')->first()->value }}</h1>
          <h2>{{ $config->where('key', 'hero-subtitle')->first()->value }}</h2>
          <div>
            <div class="text-center text-lg-start">
              <a href="#content" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Cek Invoice Sekarang</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <section id="content" class="content">
      <div class="container" id="app">
        <header class="section-header">
          {{-- <h2>Our Values</h2> --}}
          <p>Cek Invoice</p>
        </header>

        <div class="row">
          <div class="col-6 mx-auto">
            <form @submit.prevent="cari">
              <div class="input-group mb-2">
                <input type="text" class="form-control" id="invoice" name="invoice" v-model="invoice" placeholder="Masukkan nomor invoice transaksi">
              </div>

              <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">Cari</button>
              </div>
            </form>
          </div>
        </div>

        <div class="row mt-5" v-if="query.length != 0">
          <div class="col-12 mx-auto table-responsive">
            <table class="table table-bordered table-hoverable">
              <thead>
                <tr class="text-center">
                  <th>No. Invoice</th>
                  <th>Pelanggan</th>
                  <th>Tanggal Order</th>
                  <th>Tanggal Selesai</th>
                  <th>Jenis Paket</th>
                  <th>Berat</th>
                  <th>Total</th>
                  <th>Status Pembayaran</th>
                </tr>
              </thead>
              <tbody>
                <tr class="text-center">
                  <td>@{{ query.no_invoice }}</td>
                  <td>@{{ query.pelanggan == null ? '' : query.pelanggan.nama }}</td>
                  <td>@{{ query.tgl_order }}</td>
                  <td>@{{ query.tgl_selesai }}</td>
                  <td>@{{ query.paket == null ? '' : query.paket.nama }}</td>
                  <td>@{{ query.berat }} Kg</td>
                  <td>Rp @{{ query.total }}</td>
                  <td>@{{ query.pembayaran }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row mt-5" v-if="query.length != 0">
          <div class="col-10 mx-auto">
            <div class="card">
              <div class="card-body mx-5">
                <h4 class="text-center font-weight-bold mt-3 mb-5">Galeri Transaksi</h4>
                
                <div class="row">
                  <div class="col-6 mb-3" v-for="(q, index) in query.foto">
                    <img :src="'storage/transaksi/' + q" alt="foto barang" class="img-thumbnail">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5" v-if="query.length != 0">
          <div class="col-10 mx-auto">
            <div class="card">
              <div class="card-body mx-5">
                <h4 class="text-center font-weight-bold mt-3 mb-5">Log Pengerjaan</h4>
                
                <div class="step pb-5" v-for="q in query.history">
                  <div>
                    <div class="circle"></div>
                    <div class="line"></div>
                  </div>
                  <div>
                    <div class="title">@{{ q == null ? '' : q.waktu }}</div>
                    <div class="body">@{{ q == null ? '' : q.status.nama }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="{{ asset('assets/landing/img/milla-laundry-logo.png') }}" alt="logo">
              {{-- <span>Milla Laundry</span> --}}
            </a>
            <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Halaman</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#hero">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#content">Cek Invoice</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Servis Kami</h4>
            <ul>
              <li>- Laundry Kiloan</li>
              <li>- Laundry Satuan</li>
              <li>- Dry Cleaning</li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Hubungi Kami</h4>
            <p>
              {{ $config->where('key', 'footer-alamat')->first()->value }}
              <br>
              <br>
              <strong>Phone :</strong> {{ $config->where('key', 'footer-hp')->first()->value }}<br>
              <strong>Email :</strong> {{ $config->where('key', 'footer-email')->first()->value }}<br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Milla Laundry & Dry Cleaning</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  {{-- Base js --}}
  {!! Html::script('js/app.js') !!}

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/landing/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/landing/js/main.js') }}"></script>

  {{-- <script src="assets/js/main.js"></script> --}}

  <script type="text/javascript" defer>
    const app = new Vue({
      el: '#app',
      data: {
        form: {
          id: '',
          invoice: '',
          pelanggan: '',
          tgl_order: '',
          tgl_selesai: '',
          paket: '',
          berat: '',
          total: '',
          pembayaran: '',
          foto: [],
        },
        invoice: '',
        query: [],
        history: [],
      },
      mounted() {
      },
      methods: {
        clear(){
          this.form.id = '',
          this.form.invoice = '',
          this.form.pelanggan = '',
          this.form.tgl_order = '',
          this.form.tgl_selesai = '',
          this.form.paket = '',
          this.form.berat = '',
          this.form.total = '',
          this.form.pembayaran = '',
          this.form.foto = []
        },
        cari(){
          axios.post("{{ route('transaksi.cari') }}", {'invoice': app.invoice})
          .then((response) => {
            const bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

            query = response.data;
            query.history.forEach(element => {
              date = new Date(element.created_at);
              waktu = date.getDate() + " " + bulan[date.getMonth()] + " " + date.getFullYear() + ", " + date.getHours() + ":" + date.getMinutes();
              element.waktu = waktu;
            });

            this.query = query;
          })
          .catch((e) => {
            console.log(e);
          });
        },
      }
    });
  </script>
</body>

</html>