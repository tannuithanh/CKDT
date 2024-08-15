<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>@yield('title', 'Kaiadmin - Bootstrap 5 Admin Dashboard')</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  {{-- <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" /> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ mix('css/layouts/app.css') }}" />
  @yield('Css')
</head>

<body>
    <!-- Overlay để làm mờ nền -->
    <div id="loadingOverlay"></div>

    <!-- Container cho loading animation -->
    <div id="loadingContainer"></div>

  <div class="wrapper">
    @include('components.sidebar')

    <div class="main-panel">
      @include('components.header')

      <div class="container">
        <div class="page-inner">
          @yield('content')
        </div>
      </div>

      @include('components.footer')
    </div>
  </div>

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/js/select2.min.js') }}"></script>
  <script src="{{ mix('js/loadingView.js') }}"></script>
  @yield('Script')
</body>

</html>
