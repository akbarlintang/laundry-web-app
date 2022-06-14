<!DOCTYPE html>
<html>
<head>
  <title>Star Admin Pro Laravel Dashboard Template</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

  {{-- Jquery ui --}}
  {!! Html::style('assets/jquery-ui-1.13.1/jquery-ui.min.css') !!}

  {{-- Bootstrap datepicker --}}
  {!! Html::style('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}

  {{-- Datatable --}}
  {!! Html::style('assets/datatable/datatables.min.css') !!}
  
  {{-- Select2 --}}
  {!! Html::style('assets/select2/css/select2.min.css') !!}

  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->

  {{-- {!! Html::style('assets/datatable/datatables.min.css') !!} --}}

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <div class="container-scroller" id="app">
    @include('layout.header')
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('breadcrumb')
          <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div id="app">
                      @yield('content')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
    </div>
  </div>

  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->
  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}
  <!-- end common js -->

  {{-- Jquery ui --}}
  {!! Html::script('assets/jquery-ui-1.13.1/jquery-ui.min.js') !!}

  {{-- Bootstrap datepicker --}}
  {!! Html::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}

  {{-- Datatable --}}
  {!! Html::script('assets/datatable/datatables.min.js') !!}

  {{-- Select2 --}}
  {!! Html::script('assets/select2/js/select2.min.js') !!}

  @yield('custom-scripts')
  @include('sweetalert::cdn')
  @include('sweetalert::view')
</body>
</html>