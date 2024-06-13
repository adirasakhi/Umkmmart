<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>General Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet"  href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet"  href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css') }}">
  <link rel="stylesheet"  href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
  <link rel="stylesheet"  href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet"  href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet"  href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA --></head>

    <body>
      <div id="app">
        <div class="main-wrapper main-wrapper-1">
          @include("partials.pages.dashboard.header-dashboard")
          @include("partials.pages.dashboard.sidebar-dashboard")
          @include("partials.pages.dashboard.content-dashboard")
          {{-- @yield("content") --}}
        </div>

        <!-- General JS Scripts -->
        <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/modules/popper.js') }}"></script>
        <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
        <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/stisla.js') }}"></script>

        <!-- JS Libraies -->
        <script src="{{ asset('assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
        <script src="{{ asset('assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
        <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('assets/js/page/index-0.js') }}"></script>

        <!-- Template JS File -->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
      </body>
      </html>